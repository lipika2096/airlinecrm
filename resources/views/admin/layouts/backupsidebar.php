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
                            <li><a class="" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                            <li><a class="" href="{{ route('employee.dashboard') }}">Employee Dashboard</a>
                            </li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-cube"></i> <span> Todo(s)</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="" href="{{ route('admin.events') }}">Calendar</a></li>
                        </ul>
                    </li>
                    <li class="menu-title">
                        <span>Employees</span>
                    </li>
                    <li class="submenu">
                        <a href="#" class="noti-dot"><i class="la la-user"></i> <span> Employees</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="" href="{{ route('admin.employees') }}">All Employees</a></li>
                            <li><a class="" href="{{ route('admin.holidays') }}">Holidays</a></li>
                            <li><a class="" href="{{ route('admin.leaves') }}">Leaves (Admin) <span
                                        class="badge rounded-pill bg-primary float-end">1</span></a></li>
                            <li><a class="" href="{{ route('employee.leaves-employee') }}">Leaves (Employee)</a>
                            </li>
                            <li><a class="" href="{{ route('admin.leave-settings') }}">Leave Settings</a></li>
                            <li><a class="" href="{{ route('admin.attendance') }}">Attendance (Admin)</a></li>
                            <li><a class="" href="{{ route('employee.attendance-employee') }}">Attendance
                                    (Employee)</a></li>
                            <li><a class="" href="{{ route('admin.departments') }}">Departments</a></li>
                            <li><a class="" href="{{ route('admin.designations') }}">Designations</a></li>
                            <li><a class="" href="{{ route('admin.timesheet') }}">Timesheet</a></li>
                            <li><a class="" href="{{ route('admin.shift-scheduling') }}">Shift & Schedule</a>
                            </li>
                            <li><a class="" href="{{ route('admin.overtime') }}">Overtime</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-rocket"></i> <span> Tasks</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="" href="{{ route('admin.tasks') }}">Tasks</a></li>
                            <li><a class="" href="{{ route('admin.task-board') }}">Task Board</a></li>
                        </ul>
                    </li>
                    <li class="">
                        <a href="{{ route('admin.leads') }}"><i class="la la-user-secret"></i> <span>Leads</span></a>
                    </li>
                    <li class="">
                        <a href="{{ route('admin.tickets') }}"><i class="la la-ticket"></i> <span>Tickets</span></a>
                    </li>
                    <li class="menu-title">
                        <span>HR</span>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-files-o"></i> <span> Sales </span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="" href="{{ route('admin.estimates') }}">Estimates</a></li>
                            <li><a class="" href="{{ route('admin.invoices') }}">Invoices</a></li>
                            <li><a class="" href="{{ route('admin.payments') }}">Payments</a></li>
                            <li><a class="" href="{{ route('admin.expenses') }}">Expenses</a></li>
                            <li><a class="" href="{{ route('admin.provident-fund') }}">Provident Fund</a></li>
                            <li><a class="" href="{{ route('admin.taxes') }}">Taxes</a></li>
                        </ul>
                    </li>
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
                        @if (auth()->user()->hasRole('admin'))
                            <li><a class="" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                        @endif
                        @if (auth()->user()->hasRole('employee'))
                            <li><a class="" href="{{ route('employee.dashboard') }}">Employee
                                    Dashboard</a></li>
                        @endif
                    </ul>
                </li>
                {{-- @if (auth()->user()->hasRole('admin'))
                    <li class="submenu">
                        <a href="#"><i class="la la-cube"></i> <span> Todo(s)</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="" href="{{ route('admin.events.status') }}">Custom Event Status</a>
                            </li>
                            <li><a class="" href="{{ route('admin.events') }}">Calendar</a></li>
                        </ul>
                    </li>
                @endif --}}
                <li class="menu-title">
                    <span>HR</span>
                </li>
                <li class="submenu">
                    <a href="#" class=""><i class="la la-user"></i> <span> Staff</span> <span
                            class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        @if (auth()->user()->hasRole('admin'))
                            <li><a class="" href="{{ route('admin.employees') }}">All Staff(s)</a></li>
                            <li><a class="" href="{{ route('admin.holidays') }}">Holidays</a></li>
                            <li><a class="" href="{{ route('admin.leaves') }}">Manage Staff Leaves</a></li>
                        @endif
                        @if (auth()->user()->hasRole('employee'))
                            <li><a class="" href="{{ route('employee.leaves-employee') }}">Leaves
                                    (Employee)</a>
                            </li>
                        @endif
                        @if (auth()->user()->hasRole('admin'))
                            <li><a class="" href="{{ route('admin.attendance') }}">View Staff(s) Attendance</a></li>
                        @endif
                        @if (auth()->user()->hasRole('employee'))
                            <li><a class="" href="{{ route('employee.attendance-employee') }}">Attendance
                                    (Employee)</a></li>

                            <li class=""><a href="{{ route('employee.resignation') }}"><i
                                        class="la la-external-link-square"></i> <span>Resignation</span></a></li>
                        @endif
                        @if (auth()->user()->hasRole('admin'))
                            <li><a class="" href="{{ route('admin.salary') }}"> Manage Staff Salary </a></li>
                            <li class="">
                                <a href="{{ route('admin.policies') }}">
                                    Staff Policies</a>
                            </li>
                            <li class=""><a href="{{ route('admin.resignation') }}">Staff Resignation(s)</a></li>
                            <li class=""><a href="{{ route('admin.termination') }}">Staff Termination(s)</a></li>
                        @endif
                    </ul>
                </li>
                @if (auth()->user()->hasRole('admin'))
                    <li class="menu-title">
                        <span>Admin</span>
                    </li>
                    {{-- <li class="submenu">
                        <a href="#" class=""><i class="la la-user"></i> <span> Categories</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                                <li><a class="" href="{{ route('admin.delay.code.category') }}">Delay Code Categories</a></li>
                                <li><a class="" href="{{ route('admin.origin') }}">Origin Categories</a></li>
                                <li><a class="" href="{{ route('admin.destination') }}">Destination Categories</a></li>
                        </ul>
                    </li>
                    <li><a class="" href="{{ route('admin.airline-library') }}"><i class="la la-address-book"></i><span>Airline Library</span></a></li>
                    <li><a class="" href="{{ route('admin.airlines') }}"><i class="la la-id-card"></i><span>Airlines</span></a></li>
                    <li><a class="" href="{{ route('admin.delay.code') }}"><i class="la la-address-book"></i><span>Delay Codes</span></a></li>
                    <li><a class="" href="{{ route('admin.designations') }}"><i class="la la-id-card"></i><span>Designations</span></a></li>
                    <li><a class="" href="{{ route('admin.departments') }}"><i class="la la-id-card"></i><span>Departments</span></a></li>
                    <li><a class="" href="{{ route('admin.flights') }}"><i class="la la-address-book"></i><span>Flights</span></a></li> --}}
                    {{-- <li><a class="" href="{{ route('admin.designations') }}"><i class="la la-id-card"></i><span>Library</span></a></li> --}}
                    {{-- <li><a class="" href="{{ route('admin.license') }}"><i class="la la-address-book"></i><span>Licenses/Approvals</span></a></li> --}}
                    <li class="submenu">
                        <a href="#"><i class="la la-cube"></i> <span>My Todo(s)</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="" href="{{ route('admin.events.status') }}">Custom Event Status</a>
                            </li>
                            <li><a class="" href="{{ route('admin.events') }}">Calendar</a></li>
                        </ul>
                    </li>
                    {{-- <li>
                        <a href="{{ route('admin.sectors') }}"><i class="la la-cog"></i> <span>Sectors</span></a>
                    </li> --}}

                    <li class="menu-title">
                        <span>Travel Agent</span>
                    </li>
                    <li class="submenu">
                        <a href="#" class=""><i class="la la-user"></i> <span>Manage Travel Agent</span>
                            <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            @if (auth()->user()->hasRole('admin'))
                                <li><a class="" href="{{ route('admin.agents') }}">All Travel Agents</a></li>
                                {{-- <li>
                                    <a href="{{ route('admin.walletrequest') }}"><span>Agent Wallet
                                            Requests</span></a>
                                </li> --}}
                            @endif
                        </ul>
                    </li>
                    <li class="menu-title">
                        <span>Airline</span>
                    </li>
                    <li class="submenu">
                        <a href="#" class="noti-dot"><i class="la la-fighter-jet"></i> <span> Airline Details</span>
                            <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            @if (auth()->user()->hasRole('admin'))
                                <li><a class="" href="{{ route('admin.airlines-details') }}">Airlines</a></li>
                            @endif
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#" class="noti-dot"><i class="la la-users"></i> <span> Group Requests</span>
                            <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="" href="{{ route('admin.groups') }}">All Group Requests</a></li>
                            <!--<li><a class="" href="{{ route('admin.groups') }}">Open Group Requests</a></li>-->
                            <!--<li><a class="" href="{{ route('admin.groups') }}">Open Group Requests</a></li>-->
                        </ul>
                    </li>
                    <li class="">
                        <a href="{{ route('admin.air-tickets') }}"><i class="la la-ticket"></i>
                            <span>Manage Reservations</span></a>
                    </li>
                    <li class="menu-title">
                        <span>Leads</span>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-files-o"></i> <span> Manage Sales Lead</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="" href="{{ route('admin.saleslead') }}">Sales Lead Entry</a></li>
                        </ul>
                    </li>
                    {{-- <li class="menu-title">
                        <span>Inventory</span>
                    </li>
                    <li>
                        <a href="{{ route('admin.inventories') }}"><i class="la la-cog"></i>
                            <span>Inventory</span></a>
                    </li>
                    <li>
                        <a href="{{ route('admin.expiry.inventories') }}"><i class="la la-cog"></i> <span>Expiry
                                Inventory</span></a>
                    </li> --}}
                @endif

            </ul>
        </div>
    </div>
</div>

<!-- /Sidebar -->

<!-- Two Col Sidebar -->
<div class="two-col-bar" id="two-col-bar">
    <div class="sidebar sidebar-twocol">
        <div class="sidebar-left slimscroll">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link " id="v-pills-dashboard-tab" title="Dashboard" data-bs-toggle="pill"
                    href="#v-pills-dashboard" role="tab" aria-controls="v-pills-dashboard" aria-selected="true">
                    <span class="material-icons-outlined">
                        home
                    </span>
                </a>
                <a class="nav-link" id="v-pills-apps-tab" title="Apps" data-bs-toggle="pill" href="#v-pills-apps"
                    role="tab" aria-controls="v-pills-apps" aria-selected="false">
                    <span class="material-icons-outlined">
                        dashboard
                    </span>
                </a>
                <a class="nav-link " id="v-pills-employees-tab" title="Employees" data-bs-toggle="pill"
                    href="#v-pills-employees" role="tab" aria-controls="v-pills-employees"
                    aria-selected="false">
                    <span class="material-icons-outlined">
                        people
                    </span>
                </a>
                <a class="nav-link " id="v-pills-clients-tab" title="Clients" data-bs-toggle="pill"
                    href="#v-pills-clients" role="tab" aria-controls="v-pills-clients" aria-selected="false">
                    <span class="material-icons-outlined">
                        person
                    </span>
                </a>
                <a class="nav-link" id="v-pills-projects-tab" title="Projects" data-bs-toggle="pill"
                    href="#v-pills-projects" role="tab" aria-controls="v-pills-projects" aria-selected="false">
                    <span class="material-icons-outlined">
                        topic
                    </span>
                </a>
                <a class="nav-link" id="v-pills-leads-tab" title="Leads" data-bs-toggle="pill"
                    href="#v-pills-leads" role="tab" aria-controls="v-pills-leads" aria-selected="false">
                    <span class="material-icons-outlined">
                        leaderboard
                    </span>
                </a>
                <a class="nav-link" id="v-pills-tickets-tab" title="Tickets" data-bs-toggle="pill"
                    href="#v-pills-tickets" role="tab" aria-controls="v-pills-tickets" aria-selected="false">
                    <span class="material-icons-outlined">
                        confirmation_number
                    </span>
                </a>
                <a class="nav-link" id="v-pills-sales-tab" title="Sales" data-bs-toggle="pill"
                    href="#v-pills-sales" role="tab" aria-controls="v-pills-sales" aria-selected="false">
                    <span class="material-icons-outlined">
                        shopping_bag
                    </span>
                </a>
                <a class="nav-link" id="v-pills-accounting-tab" title="Accounting" data-bs-toggle="pill"
                    href="#v-pills-accounting" role="tab" aria-controls="v-pills-accounting"
                    aria-selected="false">
                    <span class="material-icons-outlined">
                        account_balance_wallet
                    </span>
                </a>
                <a class="nav-link" id="v-pills-payroll-tab" title="Payroll" data-bs-toggle="pill"
                    href="#v-pills-payroll" role="tab" aria-controls="v-pills-payroll" aria-selected="false">
                    <span class="material-icons-outlined">
                        request_quote
                    </span>
                </a>
                <a class="nav-link" id="v-pills-policies-tab" title="Policies" data-bs-toggle="pill"
                    href="#v-pills-policies" role="tab" aria-controls="v-pills-policies" aria-selected="false">
                    <span class="material-icons-outlined">
                        verified_user
                    </span>
                </a>
                <a class="nav-link " id="v-pills-reports-tab" title="Reports" data-bs-toggle="pill"
                    href="#v-pills-reports" role="tab" aria-controls="v-pills-reports" aria-selected="false">
                    <span class="material-icons-outlined">
                        report_gmailerrorred
                    </span>
                </a>
                <a class="nav-link" id="v-pills-performance-tab" title="Performance" data-bs-toggle="pill"
                    href="#v-pills-performance" role="tab" aria-controls="v-pills-performance"
                    aria-selected="false">
                    <span class="material-icons-outlined">
                        shutter_speed
                    </span>
                </a>
                <a class="nav-link " id="v-pills-goals-tab" title="Goals" data-bs-toggle="pill"
                    href="#v-pills-goals" role="tab" aria-controls="v-pills-goals" aria-selected="false">
                    <span class="material-icons-outlined">
                        track_changes
                    </span>
                </a>
                <a class="nav-link" id="v-pills-training-tab" title="Training" data-bs-toggle="pill"
                    href="#v-pills-training" role="tab" aria-controls="v-pills-training" aria-selected="false">
                    <span class="material-icons-outlined">
                        checklist_rtl
                    </span>
                </a>
                <a class="nav-link" id="v-pills-promotion-tab" title="Promotions" data-bs-toggle="pill"
                    href="#v-pills-promotion" role="tab" aria-controls="v-pills-promotion"
                    aria-selected="false">
                    <span class="material-icons-outlined">
                        auto_graph
                    </span>
                </a>
                <a class="nav-link" id="v-pills-resignation-tab" title="Resignation" data-bs-toggle="pill"
                    href="#v-pills-resignation" role="tab" aria-controls="v-pills-resignation"
                    aria-selected="false">
                    <span class="material-icons-outlined">
                        do_not_disturb_alt
                    </span>
                </a>
                <a class="nav-link" id="v-pills-termination-tab" title="Termination" data-bs-toggle="pill"
                    href="#v-pills-termination" role="tab" aria-controls="v-pills-termination"
                    aria-selected="false">
                    <span class="material-icons-outlined">
                        indeterminate_check_box
                    </span>
                </a>
                <a class="nav-link" id="v-pills-assets-tab" title="Assets" data-bs-toggle="pill"
                    href="#v-pills-assets" role="tab" aria-controls="v-pills-assets" aria-selected="false">
                    <span class="material-icons-outlined">
                        web_asset
                    </span>
                </a>
                <a class="nav-link " id="v-pills-jobs-tab" title="Jobs" data-bs-toggle="pill"
                    href="#v-pills-jobs" role="tab" aria-controls="v-pills-jobs" aria-selected="false">
                    <span class="material-icons-outlined">
                        work_outline
                    </span>
                </a>
                <a class="nav-link" id="v-pills-knowledgebase-tab" title="Knowledgebase" data-bs-toggle="pill"
                    href="#v-pills-knowledgebase" role="tab" aria-controls="v-pills-knowledgebase"
                    aria-selected="false">
                    <span class="material-icons-outlined">
                        school
                    </span>
                </a>
                <a class="nav-link" id="v-pills-activities-tab" title="Activities" data-bs-toggle="pill"
                    href="#v-pills-activities" role="tab" aria-controls="v-pills-activities"
                    aria-selected="false">
                    <span class="material-icons-outlined">
                        toggle_off
                    </span>
                </a>
                <a class="nav-link" id="v-pills-users-tab" title="Users" data-bs-toggle="pill"
                    href="#v-pills-users" role="tab" aria-controls="v-pills-users" aria-selected="false">
                    <span class="material-icons-outlined">
                        group_add
                    </span>
                </a>
                <a class="nav-link" id="v-pills-settings-tab" title="Settings" data-bs-toggle="pill"
                    href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">
                    <span class="material-icons-outlined">
                        settings
                    </span>
                </a>
                <a class="nav-link" id="v-pills-profile-tab" title="Profile" data-bs-toggle="pill"
                    href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                    <span class="material-icons-outlined">
                        manage_accounts
                    </span>
                </a>
                <a class="nav-link" id="v-pills-authentication-tab" title="Authentication" data-bs-toggle="pill"
                    href="#v-pills-authentication" role="tab" aria-controls="v-pills-authentication"
                    aria-selected="false">
                    <span class="material-icons-outlined">
                        perm_contact_calendar
                    </span>
                </a>
                <a class="nav-link" id="v-pills-errorpages-tab" title="Error Pages" data-bs-toggle="pill"
                    href="#v-pills-errorpages" role="tab" aria-controls="v-pills-errorpages"
                    aria-selected="false">
                    <span class="material-icons-outlined">
                        announcement
                    </span>
                </a>
                <a class="nav-link" id="v-pills-subscriptions-tab" title="Subscriptions" data-bs-toggle="pill"
                    href="#v-pills-subscriptions" role="tab" aria-controls="v-pills-subscriptions"
                    aria-selected="false">
                    <span class="material-icons-outlined">
                        loyalty
                    </span>
                </a>
                <a class="nav-link" id="v-pills-pages-tab" title="Pages" data-bs-toggle="pill"
                    href="#v-pills-pages" role="tab" aria-controls="v-pills-pages" aria-selected="false">
                    <span class="material-icons-outlined">
                        layers
                    </span>
                </a>
                <a class="nav-link" id="v-pills-forms-tab" title="Forms" data-bs-toggle="pill"
                    href="#v-pills-forms" role="tab" aria-controls="v-pills-forms" aria-selected="false">
                    <span class="material-icons-outlined">
                        view_day
                    </span>
                </a>
                <a class="nav-link" id="v-pills-tables-tab" title="Tables" data-bs-toggle="pill"
                    href="#v-pills-tables" role="tab" aria-controls="v-pills-tables" aria-selected="false">
                    <span class="material-icons-outlined">
                        table_rows
                    </span>
                </a>
                <a class="nav-link" id="v-pills-documentation-tab" title="Documentation" data-bs-toggle="pill"
                    href="#v-pills-documentation" role="tab" aria-controls="v-pills-documentation"
                    aria-selected="false">
                    <span class="material-icons-outlined">
                        description
                    </span>
                </a>
                <a class="nav-link" id="v-pills-changelog-tab" title="Changelog" data-bs-toggle="pill"
                    href="#v-pills-changelog" role="tab" aria-controls="v-pills-changelog"
                    aria-selected="false">
                    <span class="material-icons-outlined">
                        sync_alt
                    </span>
                </a>
                <a class="nav-link" id="v-pills-multilevel-tab" title="Multilevel" data-bs-toggle="pill"
                    href="#v-pills-multilevel" role="tab" aria-controls="v-pills-multilevel"
                    aria-selected="false">
                    <span class="material-icons-outlined">
                        library_add_check
                    </span>
                </a>
            </div>
        </div>

        <div class="sidebar-right">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade" id="v-pills-dashboard" role="tabpanel"
                    aria-labeledby="v-pills-dashboard-tab">
                    <p>Dashboard</p>
                    <ul>
                        <li>
                            <a class="" href="dashboard">Admin Dashboard</a>
                        </li>
                        <li>
                            <a class="" href="employee-dashboard">Employee Dashboard</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-pane fade " id="v-pills-apps" role="tabpanel" aria-labelledby="v-pills-apps-tab">
                    <p>App</p>
                    <ul>
                        <li>
                            <a class="" href="events">Calendar</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="v-pills-employees" role="tabpanel"
                    aria-labelledby="v-pills-employees-tab">
                    <p>Employees</p>
                    <ul>
                        <li><a class="" href="employees">All Employees</a></li>
                        <li><a class="" href="holidays">Holidays</a></li>
                        <li><a class="" href="leaves">Leaves (Admin) <span
                                    class="badge rounded-pill bg-primary float-end">1</span></a></li>
                        <li><a class="" href="leaves-employee">Leaves (Employee)</a></li>
                        <li><a class="" href="leave-settings">Leave Settings</a></li>
                        <li><a class="" href="attendance">Attendance (Admin)</a></li>
                        <li><a class="" href="attendance-employee">Attendance (Employee)</a></li>
                        <li><a class="" href="departments">Departments</a></li>
                        <li><a class="" href="designations">Designations</a></li>
                        <li><a class="" href="timesheet">Timesheet</a></li>
                        <li><a class="" href="shift-scheduling">Shift & Schedule</a></li>
                        <li><a class="" href="overtime">Overtime</a></li>
                    </ul>
                </div>
                <div class="tab-pane fade " id="v-pills-projects" role="tabpanel"
                    aria-labelledby="v-pills-projects-tab">
                    <p>Task</p>
                    <ul>

                        <li><a class="" href="tasks">Tasks</a></li>
                        <li><a class="" href="task-board">Task Board</a></li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="v-pills-leads" role="tabpanel" aria-labelledby="v-pills-leads-tab">
                    <p>Leads</p>
                    <ul>
                        <li><a class="" href="leads">Leads</a></li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="v-pills-tickets" role="tabpanel"
                    aria-labelledby="v-pills-tickets-tab">
                    <p>Tickets</p>
                    <ul>
                        <li><a class="" href="tickets">Tickets</a></li>
                    </ul>
                </div>
                <div class="tab-pane fade " id="v-pills-sales" role="tabpanel" aria-labelledby="v-pills-sales-tab">
                    <p>Sales</p>
                    <ul>
                        <li><a class="" href="estimates">Estimates</a></li>
                        <li><a class="" href="invoices">Invoices</a></li>
                        <li><a class="" href="payments">Payments</a></li>
                        <li><a class="" href="expenses">Expenses</a></li>
                        <li><a class="" href="provident-fund">Provident Fund</a></li>
                        <li><a class="" href="taxes">Taxes</a></li>
                    </ul>
                </div>
                <div class="tab-pane fade " id="v-pills-accounting" role="tabpanel"
                    aria-labelledby="v-pills-accounting-tab">
                    <p>Accounting</p>
                    <ul>
                        <li><a class="" href="categories">Categories</a></li>
                        <li><a class="" href="budgets">Budgets</a></li>
                        <li><a class="" href="budget-expenses">Budget Expenses</a></li>
                        <li><a class="" href="budget-revenues">Budget Revenues</a></li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="v-pills-payroll" role="tabpanel"
                    aria-labelledby="v-pills-payroll-tab">
                    <p>Payroll</p>
                    <ul>
                        <li><a class="" href="salary"> Employee Salary </a></li>
                        <!--<li><a class="" href="payroll-items"> Payroll Items </a></li>-->
                    </ul>
                </div>
                <div class="tab-pane fade" id="v-pills-policies" role="tabpanel"
                    aria-labelledby="v-pills-policies-tab">
                    <p>Policies</p>
                    <ul>
                        <li><a class="" href="policies"> Policies </a></li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="v-pills-reports" role="tabpanel"
                    aria-labelledby="v-pills-reports-tab">
                    <p>Reports</p>
                    <ul>
                        <li><a class="" href="expense-reports"> Expense Report </a></li>
                        <li><a class="" href="invoice-reports"> Invoice Report </a></li>
                        <li><a class="" href="payments-reports"> Payments Report </a></li>
                        <li><a class="" href="project-reports"> Project Report </a></li>
                        <li><a class="" href="task-reports"> Task Report </a></li>
                        <li><a class="" href="user-reports"> User Report </a></li>
                        <li><a class="" href="employee-reports"> Employee Report </a></li>
                        <li><a class="" href="payslip-reports"> Payslip Report </a></li>
                        <li><a class="" href="attendance-reports"> Attendance Report </a></li>
                        <li><a class="" href="leave-reports"> Leave Report </a></li>
                        <li><a class="" href="daily-reports"> Daily Report </a></li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="v-pills-performance" role="tabpanel"
                    aria-labelledby="v-pills-performance-tab">
                    <p>Performance</p>
                    <ul>
                        <li><a class="" href="performance-indicator"> Performance Indicator </a></li>
                        <li><a class="" href="performance"> Performance Review </a></li>
                        <li><a class="" href="performance-appraisal"> Performance Appraisal </a></li>
                    </ul>
                </div>
                <div class="tab-pane fade " id="v-pills-goals" role="tabpanel" aria-labelledby="v-pills-goals-tab">
                    <p>Goals</p>
                    <ul>
                        <li><a class="" href="goal-tracking"> Goal List </a></li>
                        <li><a class="" href="goal-type"> Goal Type </a></li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="v-pills-training" role="tabpanel"
                    aria-labelledby="v-pills-training-tab">
                    <p>Training</p>
                    <ul>
                        <li><a class="" href="training"> Training List </a></li>
                        <li><a class="" href="trainers"> Trainers</a></li>
                        <li><a class="" href="training-type"> Training Type </a></li>
                    </ul>
                </div>
                <div class="tab-pane fade " id="v-pills-promotion" role="tabpanel"
                    aria-labelledby="v-pills-promotion-tab">
                    <p>Promotion</p>
                    <ul>
                        <li><a class="" href="promotion"> Promotion </a></li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="v-pills-resignation" role="tabpanel"
                    aria-labelledby="v-pills-resignation-tab">
                    <p>Resignation</p>
                    <ul>
                        <li><a class="" href="resignation"> Resignation </a></li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="v-pills-termination" role="tabpanel"
                    aria-labelledby="v-pills-termination-tab">
                    <p>Termination</p>
                    <ul>
                        <li><a class="" href="termination"> Termination </a></li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="v-pills-assets" role="tabpanel" aria-labelledby="v-pills-assets-tab">
                    <p>Assets</p>
                    <ul>
                        <li><a class="" href="assets"> Assets </a></li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="v-pills-jobs" role="tabpanel" aria-labelledby="v-pills-jobs-tab">
                    <p>Jobs</p>
                    <ul>
                        <li><a class="" href="{{ route('admin.user-dashboard') }}"> User Dasboard </a></li>
                        <li><a class="" href="jobs-dashboard"> Jobs Dasboard </a></li>
                        <li><a class="" href="jobs"> Manage Jobs </a></li>
                        <li><a class="" href="manage-resumes"> Manage Resumes </a></li>
                        <li><a class="" href="shortlist-candidates"> Shortlist Candidates </a></li>
                        <li><a class="" href="interview-questions"> Interview Questions </a></li>
                        <li><a class="" href="offer_approvals"> Offer Approvals </a></li>
                        <li><a class="" href="experiance-level"> Experience Level </a></li>
                        <li><a class="" href="candidates"> Candidates List </a></li>
                        <li><a class="" href="schedule-timing"> Schedule timing </a></li>
                        <li><a class="" href="apptitude-result"> Aptitude Results </a></li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="v-pills-knowledgebase" role="tabpanel"
                    aria-labelledby="v-pills-knowledgebase-tab">
                    <p>Knowledgebase</p>
                    <ul>
                        <li><a class="" href="knowledgebase"> Knowledgebase </a></li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="v-pills-activities" role="tabpanel"
                    aria-labelledby="v-pills-activities-tab">
                    <p>Activities</p>
                    <ul>
                        <li><a class="" href="activities" class="active"> Activities </a></li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="v-pills-users" role="tabpanel"
                    aria-labelledby="v-pills-activities-tab">
                    <p>Users</p>
                    <ul>
                        <li><a class="" href="users"> Users </a></li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel"
                    aria-labelledby="v-pills-settings-tab">
                    <p>Settings</p>
                    <ul>
                        <li><a href="settings"> Settings </a></li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                    aria-labelledby="v-pills-profile-tab">
                    <p>Profile</p>
                    <ul>
                        <li><a class="" href="profile"> Employee Profile </a></li>
                        <li><a class="" href="client-profile"> Client Profile </a></li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="v-pills-authentication" role="tabpanel"
                    aria-labelledby="v-pills-authentication-tab">
                    <p>Authentication</p>
                    <ul>
                        <li><a href="index"> Login </a></li>
                        <li><a href="register"> Register </a></li>
                        <li><a href="forgot-password"> Forgot Password </a></li>
                        <li><a href="otp"> OTP </a></li>
                        <li><a href="lock-screen"> Lock Screen </a></li>
                    </ul>
                </div>

                <div class="tab-pane fade " id="v-pills-subscriptions" role="tabpanel"
                    aria-labelledby="v-pills-subscriptions-tab">
                    <p>Subscriptions</p>
                    <ul>
                        <li><a class="" href="subscriptions"> Subscriptions (Admin) </a></li>
                        <li><a class="" href="subscriptions-company"> Subscriptions (Company) </a></li>
                        <li><a class="" href="subscribed-companies"> Subscribed Companies</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Two Col Sidebar -->
