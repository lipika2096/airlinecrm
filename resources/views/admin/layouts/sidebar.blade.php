<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <nav class="greedys sidebar-horizantal">
                <ul class="list-inline-item list-unstyled links">
                    <li class="menu-title">
                        <span>Main</span>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-dashboard"></i> <span> Dashboard</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            @if (auth('admin')->user())
                                <li><a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                                <li><a class="{{ request()->routeIs('admin.events') ? 'active' : '' }}" href="{{ route('admin.events') }}">My Todo(s)</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                    @if(auth('admin')->user()->can('admin-view'))
                        <li class="menu-title">
                            <span>Admin View</span>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('admin.admin.view') ? 'active' : '' }}" href="{{ route('admin.admin.view') }}">Manage Admin</a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('admin.kyc.documents') ? 'active' : '' }}" href="{{ route('admin.kyc.documents') }}">Manage Documents</a>
                        </li>
                    @endif


                    @if(auth('admin')->user()->can('roles-permissions'))
                        <li class="menu-title">
                            <span>Roles n Permissions</span>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('admin.roles-permissions.index') ? 'active' : '' }}" href="{{ route('admin.roles-permissions.index') }}">Manage Roles n Permissions</a>
                        </li>
                    @endif

                    @if(auth('admin')->user()->can('hr'))
                        <li class="menu-title">
                            <span>HR</span>
                        </li>
                        <li class="submenu">
                            <a href="#" class=""><i class="la la-user"></i> <span> HR</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
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


                    @if (auth('admin')->user())
                        <li class="menu-title">
                            <span>Admin</span>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><i class="la la-cube"></i> <span>Admin</span> <span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a class="{{ request()->routeIs('admin.departments') ? 'active' : '' }}" href="{{route('admin.departments')}}">Add Departments</a></li>
                                <li><a class="{{ request()->routeIs('admin.designations') ? 'active' : '' }}" href="{{route('admin.designations')}}">Add Designations</a></li>
                                <li><a class="{{ request()->routeIs('admin.categories.view') ? 'active' : '' }}" href="{{route('admin.categories.view')}}">Add Category</a></li>
                                <li><a class="{{ request()->routeIs('admin.faretypes') ? 'active' : '' }}" href="{{route('admin.faretypes')}}">Add Fare Types</a></li>
                                <li><a class="{{ request()->routeIs('admin.discounts') ? 'active' : '' }}" href="{{route('admin.discounts')}}">Add Discounts</a></li>

                                <li><a class="{{ request()->routeIs('admin.duties') ? 'active' : '' }}" href="{{route('admin.duties')}}">Add Duties</a></li>
                                <li><a class="{{ request()->routeIs('admin.events.status') ? 'active' : '' }}" href="{{ route('admin.events.status') }}">Add Status</a></li>
                                <li><a class="{{ request()->routeIs('admin.leave-type') ? 'active' : '' }}" href="{{ route('admin.leave-type') }}">Add Leave Types</a></li>
                                <li><a class="{{ request()->routeIs('admin.comingSoon') ? 'active' : '' }}" href="{{ route('admin.comingSoon') }}">Add Agent Types</a></li>
                                <li><a class="{{ request()->routeIs('admin.comingSoon') ? 'active' : '' }}" href="{{ route('admin.comingSoon') }}">Add Report Types</a></li>
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
                            </ul>
                        </li>

                        <li class="menu-title">
                            <span>Travel Agent</span>
                        </li>
                        <li class="submenu">
                            <a href="#" class=""><i class="la la-user"></i> <span>Travel Agent</span>
                                <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                @if (auth('admin')->user())

                                     <li><a class="{{ request()->routeIs('admin.agents') ? 'active' : '' }}" href="{{ route('admin.agents') }}">Travel Partners List</a></li>
                                    <li><a class="{{ request()->routeIs('admin.agent-library') ? 'active' : '' }}" href="{{ route('admin.agent-library') }}">Library</a></li>
                                    <li><a class="{{ request()->routeIs('admin.agent-reports') ? 'active' : '' }}" href="{{ route('admin.agent-reports') }}">Reports</a></li>
                                     <li><a class="{{ request()->routeIs('admin.view.case-history') ? 'active' : '' }}" href="{{ route('admin.view.case-history') }}">Case History</a></li>
                                @endif
                            </ul>
                        </li>
                        <li class="menu-title">
                            <span>Airline</span>
                        </li>
                        <li class="submenu">
                            <a href="#" class=""><i class="la la-fighter-jet"></i> <span> Airline</span>
                                <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                @if (auth('admin')->user())
                                    <li><a class="{{ request()->routeIs('admin.airlines-details') ? 'active' : '' }}" href="{{ route('admin.airlines-details') }}">Airlines List</a></li>
                                    <li><a class="{{ request()->routeIs('admin.airline-library') ? 'active' : '' }}" href="{{ route('admin.airline-library') }}">Library</a></li>
                                    <li><a class="{{ request()->routeIs('admin.airline-reports') ? 'active' : '' }}" href="{{ route('admin.airline-reports') }}">Reports</a></li>
                                @endif
                            </ul>
                        </li>
                        <li class="menu-title">
                            <span>Sales & Marketing</span>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="la la-files-o"></i> <span>Sales & Marketing</span> <span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a class="{{ request()->routeIs('admin.saleslead') ? 'active' : '' }}" href="{{ route('admin.saleslead') }}">Add Sales Lead</a></li>
                                <li><a class="{{ request()->routeIs('admin.comingSoon') ? 'active' : '' }}" href="{{url('/admin/coming-soon')}}">Record Sales call/Visit</a></li>
                            </ul>
                        </li>

                        <li class="menu-title">
                            <span>Reservations</span>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="la la-ticket"></i> <span>Reservations</span> <span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a class="{{ request()->routeIs('admin.air-tickets') ? 'active' : '' }}" href="{{ route('admin.air-tickets') }}">Manage Reservations</a></li>
                                <li><a class="{{ request()->routeIs('admin.comingSoon') ? 'active' : '' }}" href="{{url('/admin/coming-soon')}}">New Sale</a></li>
                                <li><a class="{{ request()->routeIs('admin.comingSoon') ? 'active' : '' }}" href="{{url('/admin/coming-soon')}}">Modify Booking</a></li>
                                <li><a class="{{ request()->routeIs('admin.comingSoon') ? 'active' : '' }}" href="{{url('/admin/coming-soon')}}">Refunds</a></li>
                                <li><a class="{{ request()->routeIs('admin.groups') ? 'active' : '' }}" href="{{ route('admin.groups') }}">Groups</a></li>
                            </ul>
                        </li>
                        <li class="menu-title">
                            <span>Accounts</span>
                        </li>
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
                    @endif
                </ul>
                <button class="viewmoremenu">More Menu</button>
                <ul class="hidden-links hidden">
                    <li class="submenu">
                        <a href="#"><i class="la la-files-o"></i> <span> Accounting </span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="" href="{{ route('admin.categories') }}">Categories</a></li>
                            <li><a class="" href="{{ route('admin.budgets') }}">Budgets</a></li>
                            <li><a class="" href="{{ route('admin.budget-expenses') }}">Budget Expenses</a>
                            </li>
                            <li><a class="" href="{{ route('admin.budget-revenues') }}">Budget Revenues</a>
                            </li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-money"></i> <span> Payroll </span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="" href="{{ route('admin.salary') }}"> Employee Salary </a></li>
                            <!--<li><a class="" href="{{ route('admin.payroll-items') }}"> Payroll Items </a></li>-->
                        </ul>
                    </li>
                    <li class="">
                        <a href="{{ route('admin.policies') }}"><i class="la la-file-pdf-o"></i>
                            <span>Policies</span></a>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-pie-chart"></i> <span> Reports </span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="" href="{{ route('admin.expense-reports') }}"> Expense Report </a>
                            </li>
                            <li><a class="" href="{{ route('admin.invoice-reports') }}"> Invoice Report </a>
                            </li>
                            <li><a class="" href="{{ route('admin.payments-reports') }}"> Payments Report </a>
                            </li>
                            <li><a class="" href="{{ route('admin.project-reports') }}"> Project Report </a>
                            </li>
                            <li><a class="" href="{{ route('admin.task-reports') }}"> Task Report </a></li>
                            <li><a class="" href="{{ route('admin.user-reports') }}"> User Report </a></li>
                            <li><a class="" href="{{ route('admin.employee-reports') }}"> Employee Report </a>
                            </li>
                            <li><a class="" href="{{ route('admin.payslip-reports') }}"> Payslip Report </a>
                            </li>
                            <li><a class="" href="{{ route('admin.attendance-reports') }}"> Attendance Report
                                </a></li>
                            <li><a class="" href="{{ route('admin.leave-reports') }}"> Leave Report </a></li>
                            <li><a class="" href="{{ route('admin.daily-reports') }}"> Daily Report </a></li>
                        </ul>
                    </li>
                    <li class="menu-title">
                        <span>Performance</span>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-graduation-cap"></i> <span> Performance </span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="" href="{{ route('admin.performance-indicator') }}"> Performance
                                    Indicator </a></li>
                            <li><a class="" href="{{ route('admin.performance-review') }}"> Performance Review
                                </a></li>
                            <li><a class="" href="{{ route('admin.performance-appraisal') }}"> Performance
                                    Appraisal </a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-crosshairs"></i> <span> Goals </span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="" href="{{ route('admin.goal-tracking') }}"> Goal List </a></li>
                            <li><a class="" href="{{ route('admin.goal-type') }}"> Goal Type </a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-edit"></i> <span> Training </span> <span
                                class="menu-arrow"></span></a>
                        <ul style->display: none;">
                            <li><a class="" href="{{ route('admin.training') }}"> Training List </a></li>
                            <li><a class="" href="{{ route('admin.trainers') }}"> Trainers</a></li>
                            <li><a class="" href="{{ route('admin.training-type') }}"> Training Type </a></li>
                        </ul>
                    </li>
                    <li class=""><a href="{{ route('admin.promotion') }}"><i class="la la-bullhorn"></i>
                            <span>Promotion</span></a></li>
                    <li class=""><a href="{{ route('admin.resignation') }}"><i
                                class="la la-external-link-square"></i> <span>Resignation</span></a></li>
                    <li class=""><a href="{{ route('admin.termination') }}"><i class="la la-times-circle"></i>
                            <span>Termination</span></a></li>
                    <li class="menu-title">
                        <span>Administration</span>
                    </li>
                    <li class="">
                        <a href="{{ route('admin.assets') }}"><i class="la la-object-ungroup"></i>
                            <span>Assets</span></a>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-briefcase"></i> <span> Jobs </span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="" href="{{ route('admin.user-dashboard') }}"> User Dasboard </a></li>
                            <li><a class="" href="{{ route('admin.jobs-dashboard') }}"> Jobs Dasboard </a></li>
                            <li><a class="" href="{{ route('admin.jobs') }}"> Manage Jobs </a></li>
                            <li><a class="" href="{{ route('admin.manage-resumes') }}"> Manage Resumes </a>
                            </li>
                            <li><a class="" href="{{ route('admin.shortlist-candidates') }}"> Shortlist
                                    Candidates </a></li>
                            <li><a class="" href="{{ route('admin.interview-questions') }}"> Interview
                                    Questions </a></li>
                            <li><a class="" href="{{ route('admin.offer-approvals') }}"> Offer Approvals </a>
                            </li>
                            <li><a class="" href="{{ route('admin.experience-level') }}"> Experience Level </a>
                            </li>
                            <li><a class="" href="{{ route('admin.candidates') }}"> Candidates List </a></li>
                            <li><a class="" href="{{ route('admin.schedule-timing') }}"> Schedule timing </a>
                            </li>
                            <li><a class="" href="{{ route('admin.apptitude-result') }}"> Aptitude Results </a>
                            </li>
                        </ul>
                    </li>
                    <li class="">
                        <a href="{{ route('admin.knowledgebase') }}"><i class="la la-question"></i>
                            <span>Knowledgebase</span></a>
                    </li>
                    <li class="">
                        <a href="{{ route('admin.activities') }}"><i class="la la-bell"></i>
                            <span>Activities</span></a>
                    </li>
                    <li class="">
                        <a href="{{ route('admin.users') }}"><i class="la la-user-plus"></i> <span>Users</span></a>
                    </li>
                    <li class="">
                        <a href="{{ route('admin.settings') }}"><i class="la la-cog"></i> <span>Settings</span></a>
                    </li>
                    <li class="menu-title">
                        <span>Pages</span>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-user"></i> <span> Profile </span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="" href="{{ route('admin.profile') }}"> Employee Profile </a></li>
                            <li><a class="" href="{{ route('admin.client-profile') }}"> Client Profile </a>
                            </li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-key"></i> <span> Authentication </span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href=""> Login </a></li>
                            <li><a href=""> Register </a></li>
                            <li><a href=""> Forgot Password </a></li>
                            <li><a href=""> OTP </a></li>
                            <li><a href=""> Lock Screen </a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-hand-o-up"></i> <span> Subscriptions </span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="" href="{{ route('admin.subscriptions') }}"> Subscriptions (Admin)
                                </a></li>
                            <li><a class="" href="{{ route('admin.subscriptions.company') }}"> Subscriptions
                                    (Company) </a></li>
                            <li><a class="" href="{{ route('admin.subscribed.companies') }}"> Subscribed
                                    Companies</a></li>
                        </ul>
                    </li>
                </ul>

            </nav>
            <ul class="sidebar-vertical">
                <li class="menu-title">
                    <span>Main</span>
                </li>

                <li class="submenu">
                    <a href="#"><i class="la la-dashboard"></i> <span> Dashboard</span> <span
                            class="menu-arrow"></span></a>
                    <ul style="display: none;">
                            <li><a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                            <li><a class="{{ request()->routeIs('admin.events') ? 'active' : '' }}" href="{{ route('admin.events') }}">My Todo(s)</a>
                            </li>
                    </ul>
                </li>
                @if(auth('admin')->user()->can('admin-view'))
                    <li class="menu-title">
                        <span>Admin View</span>
                    </li>
                    <li>
                        <a class="{{ request()->routeIs('admin.admin.view') ? 'active' : '' }}" href="{{ route('admin.admin.view') }}">Manage Admin</a>
                    </li>
                    <li>
                        <a class="{{ request()->routeIs('admin.kyc.documents') ? 'active' : '' }}" href="{{ route('admin.kyc.documents') }}">Manage Documents</a>
                    </li>
                @endif


                @if(auth('admin')->user()->can('roles-permissions'))
                    <li class="menu-title">
                        <span>Roles n Permissions</span>
                    </li>
                    <li>
                        <a class="{{ request()->routeIs('admin.roles-permissions.index') ? 'active' : '' }}" href="{{ route('admin.roles-permissions.index') }}">Manage Roles n Permissions</a>
                    </li>
                @endif

                @if(auth('admin')->user()->can('hr'))
                    <li class="menu-title">
                        <span>HR</span>
                    </li>
                    <li class="submenu">
                        <a href="#" class=""><i class="la la-user"></i> <span> HR</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
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

                @if(auth('admin')->user()->can('admin-menu'))
                    <li class="menu-title">
                        <span>Admin</span>
                    </li>
                    <li class="submenu">
                        <a href="javascript:void(0);"><i class="la la-cube"></i> <span>Admin</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ request()->routeIs('admin.departments') ? 'active' : '' }}" href="{{route('admin.departments')}}">Add Departments</a></li>
                            <li><a class="{{ request()->routeIs('admin.designations') ? 'active' : '' }}" href="{{route('admin.designations')}}">Add Designations</a></li>
                            <li><a class="{{ request()->routeIs('admin.categories.view') ? 'active' : '' }}" href="{{route('admin.categories.view')}}">Add Category</a></li>
                            <li><a class="{{ request()->routeIs('admin.faretypes') ? 'active' : '' }}" href="{{route('admin.faretypes')}}">Add Fare Types</a></li>
                            <li><a class="{{ request()->routeIs('admin.discounts') ? 'active' : '' }}" href="{{route('admin.discounts')}}">Add Discounts</a></li>

                            <li><a class="{{ request()->routeIs('admin.duties') ? 'active' : '' }}" href="{{route('admin.duties')}}">Add Duties</a></li>
                            <!-- <li><a class="" href="javascript:void(0);">Add Public Holidays</a></li> -->
                            <li><a class="{{ request()->routeIs('admin.events.status') ? 'active' : '' }}" href="{{ route('admin.events.status') }}">Add Status</a></li>
                            <li><a class="{{ request()->routeIs('admin.leave-type') ? 'active' : '' }}" href="{{ route('admin.leave-type') }}">Add Leave Types</a></li>
                            <li><a class="{{ request()->routeIs('admin.comingSoon') ? 'active' : '' }}" href="{{ route('admin.comingSoon') }}">Add Agent Types</a></li>
                            <li><a class="{{ request()->routeIs('admin.comingSoon') ? 'active' : '' }}" href="{{ route('admin.comingSoon') }}">Add Report Types</a></li>
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
                        </ul>
                    </li>
                @endif
                @if(auth('admin')->user()->can('travel-agent'))
                    <li class="menu-title">
                        <span>Travel Agent</span>
                    </li>
                    <li class="submenu">
                        <a href="#" class=""><i class="la la-user"></i> <span>Travel Agent</span>
                            <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            @if (auth('admin')->user())

                                 <li><a class="{{ request()->routeIs('admin.agents') ? 'active' : '' }}" href="{{ route('admin.agents') }}">Travel Partners List</a></li>
                                <li><a class="{{ request()->routeIs('admin.agent-library') ? 'active' : '' }}" href="{{ route('admin.agent-library') }}">Library</a></li>
                                <li><a class="{{ request()->routeIs('admin.agent-reports') ? 'active' : '' }}" href="{{ route('admin.agent-reports') }}">Reports</a></li>
                                 <li><a class="{{ request()->routeIs('admin.view.case-history') ? 'active' : '' }}" href="{{ route('admin.view.case-history') }}">Case History</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(auth('admin')->user()->can('airline'))
                    <li class="menu-title">
                        <span>Airline</span>
                    </li>
                    <li class="submenu">
                        <a href="#" class=""><i class="la la-fighter-jet"></i> <span> Airline</span>
                            <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            @if (auth('admin')->user())
                                <li><a class="{{ request()->routeIs('admin.airlines-details') ? 'active' : '' }}" href="{{ route('admin.airlines-details') }}">Airlines List</a></li>
                                <li><a class="{{ request()->routeIs('admin.airline-library') ? 'active' : '' }}" href="{{ route('admin.airline-library') }}">Library</a></li>
                                <li><a class="{{ request()->routeIs('admin.airline-reports') ? 'active' : '' }}" href="{{ route('admin.airline-reports') }}">Reports</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(auth('admin')->user()->can('sales-marketing'))
                    <li class="menu-title">
                        <span>Sales & Marketing</span>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-files-o"></i> <span>Sales & Marketing</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ request()->routeIs('admin.saleslead') ? 'active' : '' }}" href="{{ route('admin.saleslead') }}">Add Sales Lead</a></li>
                            <li><a class="{{ request()->routeIs('admin.comingSoon') ? 'active' : '' }}" href="{{url('/admin/coming-soon')}}">Record Sales call/Visit</a></li>
                        </ul>
                    </li>

                @endif
                @if(auth('admin')->user()->can('reservations'))
                    <li class="menu-title">
                        <span>Reservations</span>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-ticket"></i> <span>Reservations</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ request()->routeIs('admin.air-tickets') ? 'active' : '' }}" href="{{ route('admin.air-tickets') }}">Manage Reservations</a></li>
                            <li><a class="{{ request()->routeIs('admin.comingSoon') ? 'active' : '' }}" href="{{url('/admin/coming-soon')}}">New Sale</a></li>
                            <li><a class="{{ request()->routeIs('admin.comingSoon') ? 'active' : '' }}" href="{{url('/admin/coming-soon')}}">Modify Booking</a></li>
                            <li><a class="{{ request()->routeIs('admin.comingSoon') ? 'active' : '' }}" href="{{url('/admin/coming-soon')}}">Refunds</a></li>
                            <li><a class="{{ request()->routeIs('admin.groups') ? 'active' : '' }}" href="{{ route('admin.groups') }}">Groups</a></li>
                        </ul>
                    </li>

                @endif
                @if(auth('admin')->user()->can('accounts'))
                    <li class="menu-title">
                        <span>Accounts</span>
                    </li>
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
                @endif
            </ul>
        </div>
    </div>
</div>

<!-- /Sidebar -->
