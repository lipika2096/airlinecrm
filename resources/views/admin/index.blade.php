@extends('admin/layouts/authentication-main')
@section('title', 'Login')
@section('content')

<style>
    .login-tabs {
        display: flex;
        border-bottom: 2px solid #e0e0e0;
        margin-bottom: 20px;
    }
    .login-tab {
        flex: 1;
        text-align: center;
        padding: 15px;
        cursor: pointer;
        font-weight: 600;
        color: #6c757d;
        transition: all 0.3s;
        background: #f8f9fa;
    }
    .login-tab.active {
        color: #007bff;
        border-bottom: 2px solid #007bff;
        background: #fff;
    }
    .login-tab:hover {
        background: #e9ecef;
    }
    .login-tab.active:hover {
        background: #fff;
    }
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
    }
</style>

        <!-- Main Wrapper -->
        <div class="main-wrapper">
            <div class="account-content">
                <div class="container">

                    <!-- /Account Logo -->

                    <div class="account-box">
                        <div class="account-wrapper">
                            
                    <!-- Account Logo -->
                    <div class="account-logo">
                        <a href="#"><img src="{{asset('public/assets/img/logo2.png')}}" alt="Dreamguy's Technologies"></a>
                    </div>
                            <p class="account-subtitle">Login to access our dashboard</p>

                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <!-- Login Tabs -->
                            <div class="login-tabs">
                                <div class="login-tab active" data-tab="admin-tab">
                                    <i class="fa fa-user-shield"></i> Super Admin
                                </div>
                                <div class="login-tab" data-tab="customer-tab">
                                    <i class="fa fa-users"></i> Customer
                                </div>
                                <div class="login-tab" data-tab="staff-tab">
                                    <i class="fa fa-user"></i> Staff
                                </div>
                            </div>

                            <!-- Admin Login Form -->
                            <div id="admin-tab" class="tab-content active">
                                <form action="{{route('admin.post.login')}}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input class="form-control" type="email" name="email" placeholder="Enter your email" required>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col">
                                                <label>Password</label>
                                            </div>
                                        </div>
                                        <div class="position-relative">
                                            <input class="form-control" type="password" id="admin-password" name="password" placeholder="Enter your password" required>
                                            <span class="fa fa-eye-slash" id="toggle-admin-password" style="position: absolute; right: 15px; top: 12px; cursor: pointer;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <button class="btn btn-primary account-btn" type="submit">Login as Admin</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Customer Login Form -->
                            <div id="customer-tab" class="tab-content">
                                <form action="{{route('customer.post.login')}}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input class="form-control" type="email" name="email" placeholder="Enter your email" required>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col">
                                                <label>Password</label>
                                            </div>
                                        </div>
                                        <div class="position-relative">
                                            <input class="form-control" type="password" id="customer-password" name="password" placeholder="Enter your password" required>
                                            <span class="fa fa-eye-slash" id="toggle-customer-password" style="position: absolute; right: 15px; top: 12px; cursor: pointer;"></span>
                                        </div>
                                        <div class="form-text text-danger">
                                            <small>Forget Password? <a href="{{ route('password.forgot') }}">Reset here</a></small>
                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <button class="btn btn-primary account-btn" type="submit">Login as Customer</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Staff Login Form -->
                            <div id="staff-tab" class="tab-content">
                                <form action="{{route('staff.login')}}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input class="form-control" type="email" name="email" placeholder="Enter your email" required>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col">
                                                <label>Password</label>
                                            </div>
                                        </div>
                                        <div class="position-relative">
                                            <input class="form-control" type="password" id="staff-password" name="password" placeholder="Enter your password" required>
                                            <span class="fa fa-eye-slash" id="toggle-staff-password" style="position: absolute; right: 15px; top: 12px; cursor: pointer;"></span>
                                        </div>
                                        <div class="form-text text-danger">
                                            <small>Forget Password? <a href="{{ route('password.forgot') }}">Reset here</a></small>
                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <button class="btn btn-primary account-btn" type="submit">Login as Staff</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Main Wrapper -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
    const tabs = document.querySelectorAll('.login-tab');
    const tabContents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            tabs.forEach(t => t.classList.remove('active'));
            // Add active class to clicked tab
            this.classList.add('active');

            // Hide all tab contents
            tabContents.forEach(content => content.classList.remove('active'));
            // Show corresponding tab content
            const tabId = this.getAttribute('data-tab');
            document.getElementById(tabId).classList.add('active');
        });
    });

    // Password toggle functionality for admin
    document.getElementById('toggle-admin-password').addEventListener('click', function() {
        const passwordInput = document.getElementById('admin-password');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            this.classList.remove('fa-eye-slash');
            this.classList.add('fa-eye');
        } else {
            passwordInput.type = 'password';
            this.classList.remove('fa-eye');
            this.classList.add('fa-eye-slash');
        }
    });

    // Password toggle functionality for customer
    document.getElementById('toggle-customer-password').addEventListener('click', function() {
        const passwordInput = document.getElementById('customer-password');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            this.classList.remove('fa-eye-slash');
            this.classList.add('fa-eye');
        } else {
            passwordInput.type = 'password';
            this.classList.remove('fa-eye');
            this.classList.add('fa-eye-slash');
        }
    });

    // Password toggle functionality for staff
    document.getElementById('toggle-staff-password').addEventListener('click', function() {
        const passwordInput = document.getElementById('staff-password');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            this.classList.remove('fa-eye-slash');
            this.classList.add('fa-eye');
        } else {
            passwordInput.type = 'password';
            this.classList.remove('fa-eye');
            this.classList.add('fa-eye-slash');
        }
    });
});
</script>
@endsection
