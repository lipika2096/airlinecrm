@extends('admin/layouts/head-main')
@section('title', 'Admin Dashboard')
@section('content')

    @php
        use Carbon\Carbon;
    @endphp

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="welcome-box">
                        <div class="welcome-img">
                            <img alt="" src="assets/img/profiles/avatar-02.jpg">
                        </div>
                        <div class="welcome-det">
                            <h3>Welcome, {{ session('admin_name') }}</h3>
                            <p>{{ Carbon::now()->format('l, d F Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <section class="dash-section">
                        <h1 class="dash-sec-title">Today </h1>
                        <div class="dash-sec-content">

                            @if ($today_leave->isEmpty())
                                <div class="dash-info-list">
                                    <div class="dash-card">
                                        <div class="dash-card-container">
                                            <div class="dash-card-icon">
                                                <i class="fa fa-suitcase"></i>
                                            </div>
                                            <div class="dash-card-content">
                                                <p>No employee is
                                                    on leave today</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                @foreach ($today_leave as $el)
                                    <div class="dash-info-list">
                                        <a href="#" class="dash-card">
                                            <div class="dash-card-container">
                                                <div class="dash-card-icon">
                                                    <i class="fa fa-hourglass-o"></i>
                                                </div>

                                                <div class="dash-card-content">
                                                    <p>{{ $el->employee->first_name }} {{ $el->employee->last_name }} is on
                                                        {{ $el->leave_type }} today</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </section>

                    <section class="dash-section">
                        <h1 class="dash-sec-title">Tomorrow</h1>
                        <div class="dash-sec-content">
                            @if ($tomorrow_leave->isEmpty())
                                <div class="dash-info-list">
                                    <div class="dash-card">
                                        <div class="dash-card-container">
                                            <div class="dash-card-icon">
                                                <i class="fa fa-suitcase"></i>
                                            </div>
                                            <div class="dash-card-content">
                                                <p>No employee is
                                                    on leave tomorrow</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                @foreach ($tomorrow_leave as $tel)
                                    <div class="dash-info-list">
                                        <div class="dash-card">
                                            <div class="dash-card-container">
                                                <div class="dash-card-icon">
                                                    <i class="fa fa-suitcase"></i>
                                                </div>
                                                <div class="dash-card-content">
                                                    <p> {{ $tel->employee->first_name }} {{ $tel->employee->last_name }} is
                                                        on {{ $tel->leave_type }} tomorrow</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </section>

                    <section class="dash-section">
                        <h1 class="dash-sec-title">Next seven days</h1>
                        <div class="dash-sec-content">
                            @if ($next_seven_days->isEmpty())
                                <div class="dash-card-content">
                                    <p>No employee is on leave for next seven days</p>
                                </div>
                            @else
                                @foreach ($next_seven_days as $nel)
                                    <div class="dash-info-list">
                                        <div class="dash-card">
                                            <div class="dash-card-container">
                                                <div class="dash-card-icon">
                                                    <i class="fa fa-suitcase"></i>
                                                </div>

                                                <div class="dash-card-content">
                                                    <p>{{ $nel->employee->first_name }} {{ $nel->employee->last_name }} is
                                                        on {{ $nel->leave_type }} from {{ $nel->from }} to
                                                        {{ $nel->to }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </section>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div class="dash-sidebar">
                        <section>
                            <h5 class="dash-title">To Do</h5>
                            <div class="card">
                                <div class="card-body">
                                    <div class="time-list">
                                        <div class="dash-stats-list">
                                            <h4>{{ $total_todo }}</h4>
                                            <p>Total To Do</p>
                                        </div>
                                        <div class="dash-stats-list">
                                            <h4>{{ $pending_todo }}</h4>
                                            <p>Pending To Do</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        @if (auth('admin')->user()->name == 'Super Admin')
                            <section>
                                <h5 class="dash-title">Subscriptions</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4" style="font-weight: bold;
    border-right: 1px solid;">

                                                <div class="dash-stats-list">
                                                    <h4>{{ $total_todo }}</h4>
                                                    <p>Total Subscriptions</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4" style="font-weight: bold;
    border-right: 1px solid;">

                                                <div class="dash-stats-list">
                                                    <h4>{{ $pending_todo }}</h4>
                                                    <p>New Subscriptions</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4" style="font-weight: bold;
    border-right: 1px solid;">

                                                <div class="dash-stats-list">
                                                    <h4>{{ $pending_todo }}</h4>
                                                    <p>Expiring Subscriptions</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section>
                                <h5 class="dash-title">Support Tickets</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="time-list">
                                            <div class="dash-stats-list">
                                                <h4>{{ $customerCount }}</h4>
                                                <p>New Support Tickets</p>
                                                <div class="request-btn">
                                                    <a class="btn btn-primary"
                                                        style="font-size: 0.8rem;margin-top: 10px;margin-bottom: -10px;margin-left:-10px;"
                                                        href="{{ route('admin.admin.view') }}">View Ticket</a>
                                                </div>
                                            </div>
                                            <div class="dash-stats-list">
                                                <h4>{{ $customerCount }}</h4>
                                                <p>Open Support Tickets</p>
                                                <div class="request-btn">
                                                    <a class="btn btn-primary"
                                                        style="font-size: 0.8rem;margin-top: 10px;margin-bottom: -10px;margin-left:-10px;"
                                                        href="{{ route('admin.admin.view') }}">View Ticket</a>
                                                </div>
                                            </div>
                                            <!-- <div class="dash-stats-list">
                                                    <h4>12</h4>
                                                    <p>Remaining</p>
                                                </div> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="time-list">
                                            <div class="dash-stats-list">
                                                <h4>{{ $customerCount }}</h4>
                                                <p>Open Support Tickets</p>
                                            </div>
                                            <!-- <div class="dash-stats-list">
                                                    <h4>12</h4>
                                                    <p>Remaining</p>
                                                </div> -->
                                        </div>
                                        <div class="request-btn">
                                            <a class="btn btn-primary" style="font-size: 0.8rem;"
                                                href="{{ route('admin.admin.view') }}">View Ticket</a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section>
                                <h5 class="dash-title">Total Customers</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="time-list">
                                            <div class="dash-stats-list">
                                                <h4>{{ $customerCount }}</h4>
                                                <p>Total No. of Customers</p>
                                            </div>
                                            <!-- <div class="dash-stats-list">
                                                        <h4>12</h4>
                                                        <p>Remaining</p>
                                                    </div> -->
                                        </div>
                                        <div class="request-btn">
                                            <a class="btn btn-primary" style="font-size: 0.8rem;"
                                                href="{{ route('admin.admin.view') }}">View Customers</a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        @else
                            <section>
                                <h5 class="dash-title">Total Agents</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="time-list">
                                            <div class="dash-stats-list">
                                                <h4>{{ $agentCount }}</h4>
                                                <p>Total No. of Agents</p>
                                            </div>
                                            <!-- <div class="dash-stats-list">
                                                    <h4>12</h4>
                                                    <p>Remaining</p>
                                                </div> -->
                                        </div>
                                        <div class="request-btn">
                                            <a class="btn btn-primary" style="font-size: 0.8rem;"
                                                href="{{ route('admin.agents') }}">View Agent</a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        @endif
                        <section>
                            <h5 class="dash-title">Upcoming Holidays</h5>
                            @if ($upcomingHolidays->isEmpty())
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="holiday-title mb-0">No holidays this month</h5>
                                    </div>
                                </div>
                            @else
                                @foreach ($upcomingHolidays as $holiday)
                                    <div class="card" style="    margin-bottom: 5px;">
                                        <div class="card-body text-center" style="padding: 0.5rem 1rem;">
                                            <h5 class="holiday-title mb-0">
                                                {{ \Carbon\Carbon::parse($holiday->holiday_date)->format('D d M Y') }} -
                                                {{ $holiday->title }}</h5>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </section>

                    </div>
                </div>
            </div>

        </div>
        <!-- /Page Content -->

    </div>
    <!-- /Page Wrapper -->
@endsection
