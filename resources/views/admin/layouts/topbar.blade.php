<!-- Header -->
<div class="header">

    <!-- Logo -->
    <div class="header-left">
         <a href="{{ \App\Helpers\RouteHelper::getDashboardRoute() }}" class="logo">
            <img src="{{asset('public/assets/img/logo2.png')}}" alt="">
        </a>
    </div>
    <!-- /Logo -->

    <style>
        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            border-bottom: 1px solid #eee;
        }
        .notification-header h6 {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
        }
        .mark-all-read {
            font-size: 12px;
            color: #ed5b24;
            text-decoration: none;
        }
        .notification-list {
            max-height: 300px;
            overflow-y: auto;
        }
        .notification-item {
            padding: 12px 15px;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
        }
        .notification-item:hover {
            background-color: #f9f9f9;
        }
        .notification-item.unread {
            background-color: #f0f7ff;
        }
        .notification-item .notification-title {
            font-weight: 600;
            font-size: 13px;
            margin-bottom: 4px;
        }
        .notification-item .notification-message {
            font-size: 12px;
            color: #666;
            margin-bottom: 4px;
        }
        .notification-item .notification-time {
            font-size: 11px;
            color: #999;
        }
        .notification-footer {
            padding: 10px 15px;
            border-top: 1px solid #eee;
            text-align: center;
        }
        .notification-footer a {
            font-size: 13px;
            color: #ed5b24;
            text-decoration: none;
        }
        .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 10px;
            padding: 3px 6px;
            border-radius: 50%;
        }
    </style>

    <a id="toggle_btn" href="javascript:void(0);">
        <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a>

    <!-- Header Title -->
    <!-- <div class="page-title-box">
        <h3>CRM SAAS</h3>
    </div> -->
    <!-- /Header Title -->

    <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>

    <!-- Header Menu -->
    <ul class="nav user-menu">
        <!-- Notifications -->
        <li class="nav-item dropdown has-arrow main-drop">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown" id="notificationDropdown">
                <span class="user-img"><i class="fa fa-bell"></i></span>
                <span class="badge badge-pill bg-danger" id="notificationBadge" style="display: none;">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="notification-header">
                    <h6>Notifications</h6>
                    <a href="#" id="markAllRead" class="mark-all-read">Mark all as read</a>
                </div>
                <div class="notification-list" id="notificationList">
                    <div class="text-center py-3">No notifications</div>
                </div>
                <div class="notification-footer">
                    <a href="#" id="viewAllNotifications">View all notifications</a>
                </div>
            </div>
        </li>
        <!-- /Message Notifications -->
        <li class="nav-item dropdown has-arrow main-drop">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img"><img src="{{asset('public/assets/img/user.jpg')}}" alt="">
                <span class="status online"></span></span>
                <span>{{\App\Helpers\RouteHelper::isStaff() ? auth()->user()->first_name." ". auth()->user()->last_name : auth('admin')->user()->name}}</span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ \App\Helpers\RouteHelper::getProfileRoute() }}">My Profile</a>
                <a class="dropdown-item" href="{{ \App\Helpers\RouteHelper::getLogoutRoute() }}">Logout</a>
            </div>
        </li>
    </ul>
    <!-- /Header Menu -->

    <!-- Mobile Menu -->
    <div class="dropdown mobile-user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{ \App\Helpers\RouteHelper::getProfileRoute() }}">My Profile</a>
            <a class="dropdown-item" href="{{ \App\Helpers\RouteHelper::getLogoutRoute() }}">Logout</a>
        </div>
    </div>
    <!-- /Mobile Menu -->

</div>
<!-- /Header -->
