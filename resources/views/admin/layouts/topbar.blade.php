<!-- Header -->
<div class="header">

    <!-- Logo -->
    <div class="header-left">
         <a href="admin-dashboard.php" class="logo">
            <img src="{{asset('public/assets/img/logo2.png')}}" width="40" height="40" alt="">
        </a>
        <a href="admin-dashboard.php" class="logo2">
            <img src="{{asset('public/assets/img/logo2.png')}}" width="40" height="40" alt="">
        </a>
    </div>
    <!-- /Logo -->

    <a id="toggle_btn" href="javascript:void(0);">
        <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a>

    <!-- Header Title -->
    <div class="page-title-box">
        <h3>HRCRM</h3>
    </div>
    <!-- /Header Title -->

    <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>

    <!-- Header Menu -->
    <ul class="nav user-menu">
        <!-- /Message Notifications -->
        <li class="nav-item dropdown has-arrow main-drop">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img"><img src="{{asset('public/assets/img/user.jpg')}}" alt="">
                <span class="status online"></span></span>
                <span>{{session('admin_name')}}</span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{route('admin.admin-profile')}}">My Profile</a>
                {{-- <a class="dropdown-item" href="{{route('admin.settings')}}">Settings</a> --}}
                <a class="dropdown-item" href="{{route('admin.logout')}}">Logout</a>
            </div>
        </li>
    </ul>
    <!-- /Header Menu -->

    <!-- Mobile Menu -->
    <div class="dropdown mobile-user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{route('admin.admin-profile')}}">My Profile</a>
            {{-- <a class="dropdown-item" href="{{route('admin.settings')}}">Settings</a> --}}
            <a class="dropdown-item" href="{{route('admin.logout')}}">Logout</a>
        </div>
    </div>
    <!-- /Mobile Menu -->

</div>
<!-- /Header -->
