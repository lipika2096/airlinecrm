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
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            background-color: #f8f9fa;
        }
        .notification-header h6 {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }
        .mark-all-read {
            font-size: 12px;
            color: #ed5b24;
            text-decoration: none;
            cursor: pointer;
            transition: color 0.2s;
        }
        .mark-all-read:hover {
            color: #c94a1a;
        }
        .notification-list {
            max-height: 350px;
            overflow-y: auto;
            min-height: 100px;
        }
        .notification-list::-webkit-scrollbar {
            width: 6px;
        }
        .notification-list::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .notification-list::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 3px;
        }
        .notification-item {
            padding: 12px 15px;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: background-color 0.2s;
            position: relative;
        }
        .notification-item:hover {
            background-color: #f9f9f9;
        }
        .notification-item.unread {
            background-color: #f0f7ff;
            border-left: 3px solid #ed5b24;
        }
        .notification-item.unread::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background-color: #ed5b24;
        }
        .notification-item .notification-title {
            font-weight: 600;
            font-size: 13px;
            margin-bottom: 4px;
            color: #333;
            line-height: 1.4;
        }
        .notification-item .notification-message {
            font-size: 12px;
            color: #666;
            margin-bottom: 6px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .notification-item .notification-time {
            font-size: 11px;
            color: #999;
        }
        .notification-footer {
            padding: 12px 15px;
            border-top: 1px solid #eee;
            text-align: center;
            background-color: #f8f9fa;
        }
        .notification-footer a {
            font-size: 13px;
            color: #ed5b24;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        .notification-footer a:hover {
            color: #c94a1a;
        }
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 10px;
            padding: 3px 6px;
            border-radius: 50%;
            background-color: #dc3545;
            color: white;
            border: 2px solid #fff;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        .notification-icon {
            position: relative;
            font-size: 18px;
            color: #555;
            transition: color 0.2s;
        }
        .notification-icon:hover {
            color: #ed5b24;
        }
        .loading-notifications {
            text-align: center;
            padding: 20px;
            color: #999;
        }
        .loading-notifications i {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .empty-notifications {
            text-align: center;
            padding: 30px 20px;
            color: #999;
        }
        .empty-notifications i {
            font-size: 24px;
            margin-bottom: 10px;
            color: #ddd;
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
                <span class="user-img notification-icon">
                    <i class="fa fa-bell"></i>
                    <span class="notification-badge" id="notificationBadge" style="display: none;">0</span>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" style="min-width: 320px;">
                <div class="notification-header">
                    <h6>Notifications</h6>
                    <a href="#" id="markAllRead" class="mark-all-read">Mark all as read</a>
                </div>
                <div class="notification-list" id="notificationList">
                    <div class="loading-notifications">
                        <i class="fa fa-spinner"></i>
                        <p>Loading notifications...</p>
                    </div>
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
