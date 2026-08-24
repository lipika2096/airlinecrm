@extends('admin/layouts/head-main')
@section('content')

@php
    use Carbon\Carbon;
    $user = auth()->guard('admin')->check() ? auth()->guard('admin')->user() : auth()->guard('employee')->user();
    $isAdmin = auth()->guard('admin')->check();
    $userDetails = $isAdmin ? ($customer->adminDetail ?? null) : null;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <style>
        .profile-header {
            background: linear-gradient(135deg, #0F2747 0%, #1a3a5c 100%);
            color: white;
            padding: 40px 0;
            margin: 0px;
            border-radius: 20px;
        }
        
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid #2563EB;
            background: #EFF6FF;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            font-weight: bold;
            color: #2563EB;
            margin: 0 auto 20px;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }
        
        .profile-name {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .profile-role {
            font-size: 16px;
            opacity: 0.9;
            background: rgba(255, 255, 255, 0.2);
            padding: 5px 15px;
            border-radius: 20px;
            display: inline-block;
        }
        
        .profile-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            margin-bottom: 20px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .profile-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .profile-card-header {
            background: #F8FAFC;
            border-bottom: 1px solid #E2E8F0;
            padding: 20px;
            border-radius: 12px 12px 0 0;
            font-weight: 600;
            color: #172033;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .profile-card-header i {
            color: #2563EB;
            font-size: 20px;
        }
        
        .profile-card-body {
            padding: 25px;
        }
        
        .info-row {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid #F1F5F9;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            width: 180px;
            font-weight: 500;
            color: #64748B;
            font-size: 14px;
        }
        
        .info-value {
            flex: 1;
            color: #172033;
            font-size: 14px;
        }
        
        .nav-tabs-custom {
            border-bottom: 2px solid #E2E8F0;
            margin-bottom: 25px;
        }
        
        .nav-tabs-custom .nav-link {
            border: none;
            color: #64748B;
            font-weight: 500;
            padding: 12px 20px;
            margin-right: 5px;
            border-radius: 8px 8px 0 0;
            transition: all 0.2s ease;
        }
        
        .nav-tabs-custom .nav-link:hover {
            color: #2563EB;
            background: #EFF6FF;
        }
        
        .nav-tabs-custom .nav-link.active {
            color: #2563EB;
            background: #EFF6FF;
            border-bottom: 2px solid #2563EB;
        }
        
        .form-control {
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 14px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        
        .form-control:focus {
            border-color: #2563EB;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        
        .form-label {
            font-weight: 500;
            color: #172033;
            font-size: 14px;
            margin-bottom: 8px;
        }
        
        .btn-primary {
            background: #2563EB;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .btn-primary:hover {
            background: #1D4ED8;
            transform: translateY(-1px);
        }
        
        .btn-secondary {
            background: #EFF6FF;
            color: #2563EB;
            border: 1px solid #2563EB;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .btn-secondary:hover {
            background: #DBEAFE;
        }
        
        .alert {
            border-radius: 8px;
            border: none;
            padding: 15px 20px;
        }
        
        .alert-success {
            background: #D1FAE5;
            color: #065F46;
        }
        
        .alert-danger {
            background: #FEE2E2;
            color: #991B1B;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);
            color: white;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
        }
        
        .stat-card h3 {
            font-size: 32px;
            font-weight: 700;
            margin: 0;
        }
        
        .stat-card p {
            margin: 5px 0 0;
            opacity: 0.9;
            font-size: 14px;
        }
        
        .password-strength {
            height: 4px;
            border-radius: 2px;
            margin-top: 8px;
            background: #E2E8F0;
            overflow: hidden;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0;
            transition: width 0.3s ease, background 0.3s ease;
        }
        
        .password-strength-weak { background: #DC2626; }
        .password-strength-medium { background: #F59E0B; }
        .password-strength-strong { background: #10B981; }
        
        .company-info-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .company-info-table tr {
            border-bottom: 1px solid #F1F5F9;
        }
        
        .company-info-table tr:last-child {
            border-bottom: none;
        }
        
        .company-info-table th {
            padding: 12px 15px;
            text-align: left;
            font-weight: 500;
            color: #64748B;
            width: 200px;
            background: #F8FAFC;
        }
        
        .company-info-table td {
            padding: 12px 15px;
            color: #172033;
        }
        
        .company-info-table ul {
            margin: 0;
            padding-left: 20px;
        }
        
        .company-info-table li {
            margin: 5px 0;
        }
        
        .text-red {
            color: #DC2626;
        }
        
        @media (max-width: 768px) {
            .profile-header {
                padding: 30px 0;
            }
            
            .info-row {
                flex-direction: column;
            }
            
            .info-label {
                width: 100%;
                margin-bottom: 5px;
            }
            
            .company-info-table th {
                width: 150px;
            }
        }
    </style>
</head>
<body>
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">My Profile</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('admin-dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-4">
                    <!-- Profile Card -->
                    <div class="profile-card">
                        <div class="profile-header">
                            <div class="profile-avatar">
                                {{ strtoupper(substr($customer->name, 0, 1)) }}
                            </div>
                            <h3 class="profile-name text-center">{{ $customer->name }}</h3>
                            <p class="text-center">
                                <span class="profile-role">
                                    {{ auth('admin')->user()->hasRole('superAdmin') ? 'Super Admin' : 'Customer' }}
                                </span>
                            </p>
                        </div>
                        
                    </div>
                </div>
                
                <div class="col-lg-8">
                    <!-- Main Content -->
                    <div class="profile-card">
                        <div class="profile-card-body">
                            <ul class="nav nav-tabs nav-tabs-custom" id="profileTab" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button">
                                        <i class="fas fa-user me-2"></i>Personal Info
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button">
                                        <i class="fas fa-lock me-2"></i>Change Password
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="company-tab" data-bs-toggle="tab" data-bs-target="#company" type="button">
                                        <i class="fas fa-building me-2"></i>Company Info
                                    </button>
                                </li>
                            </ul>
                            
                            <div class="tab-content mt-4" id="profileTabContent">
                                <!-- Personal Information Tab -->
                                <div class="tab-pane fade show active" id="personal" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Full Name</label>
                                                <input type="text" class="form-control" value="{{ $customer->name }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Email Address</label>
                                                <input type="email" class="form-control" value="{{ $customer->email }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Account Status</label>
                                                <input type="text" class="form-control" value="{{ $customer->is_active ? 'Active' : 'Inactive' }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Created At</label>
                                                <input type="text" class="form-control" value="{{ $customer->created_at ? Carbon::parse($customer->created_at)->format('M d, Y') : '-' }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Personal information is view-only. To update your password, use the "Change Password" tab.
                                    </div>
                                </div>
                                
                                <!-- Change Password Tab -->
                                <div class="tab-pane fade" id="password" role="tabpanel">
                                    <div id="password-section">
                                        @if(session('password_success'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                {{ session('password_success') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                            </div>
                                        @endif
                                        
                                        @if(session('password_error'))
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                {{ session('password_error') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                            </div>
                                        @endif
                                        
                                        <form action="{{ route('admin.profile.password') }}" method="POST" id="passwordForm">
                                            @csrf
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Current Password</label>
                                                <input type="password" class="form-control" name="current_password" required>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">New Password</label>
                                                <input type="password" class="form-control" name="new_password" id="newPassword" required minlength="8">
                                                <div class="password-strength">
                                                    <div class="password-strength-bar" id="passwordStrengthBar"></div>
                                                </div>
                                                <small class="text-muted">Minimum 8 characters with mix of letters, numbers & symbols</small>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Confirm New Password</label>
                                                <input type="password" class="form-control" name="confirm_password" id="confirmPassword" required minlength="8">
                                            </div>
                                            
                                            <div class="d-flex gap-2">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-key me-2"></i>Update Password
                                                </button>
                                                <button type="reset" class="btn btn-secondary">
                                                    <i class="fas fa-undo me-2"></i>Reset
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                
                                <!-- Company Details Tab -->
                                <div class="tab-pane fade" id="company" role="tabpanel">
                                    <div id="company-section">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="mb-0">Company Information</h5>
                                            <span class="badge bg-secondary">View Only</span>
                                        </div>
                                        
                                        <div class="table-responsive">
                                            <table class="company-info-table">
                                                <tbody>
                                                    <tr>
                                                        <th>Company Name</th>
                                                        <td>{{ $customer->adminDetail->company_name ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Brand Name</th>
                                                        <td>{{ $customer->name ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Group</th>
                                                        <td>{{ $customer->adminDetail->group ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Street Address</th>
                                                        <td>{{ $customer->adminDetail->address ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>City</th>
                                                        <td>{{ $customer->adminDetail->city ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Pincode</th>
                                                        <td>{{ $customer->adminDetail->pincode ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Country</th>
                                                        <td>{{ $customer->adminDetail->country ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Company Reg. No.</th>
                                                        <td>{{ $customer->adminDetail->company_registration_no ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-red">Subscription Type</th>
                                                        <td class="text-red">{{ $customer->adminDetail->subscription_type ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-red">Subscription Charge</th>
                                                        <td class="text-red">{{ $customer->adminDetail->subscription_charge ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-red">Subscription Expiring</th>
                                                        <td class="text-red">{{ $customer->adminDetail->subscription_expiring ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-red">Remarks</th>
                                                        <td class="text-red">{{ $customer->adminDetail->remarks ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-red">Business Model</th>
                                                        <td class="text-red">{{ $customer->adminDetail->business_mode ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Focused Destinations</th>
                                                        <td>
                                                            <ul>
                                                                @if (!empty($customer->adminDetail?->business_focus))
                                                                    @foreach (json_decode($customer->adminDetail->business_focus, true) ?? [] as $destination)
                                                                        <li>{{ $destination ?? '-' }}</li>
                                                                    @endforeach
                                                                @endif
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Key People</th>
                                                        <td>{{ $customer->adminDetail->key_people ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Parent Company</th>
                                                        <td>{{ $customer->adminDetail->parent_company ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Headquarters</th>
                                                        <td>{{ $customer->adminDetail->headquarters ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Websites</th>
                                                        <td>
                                                            <ul>
                                                                @if (!empty($customer->adminDetail?->websites))
                                                                    @foreach (json_decode($customer->adminDetail->websites, true) ?? [] as $websites)
                                                                        <li>{{ $websites ?? '-' }}</li>
                                                                    @endforeach
                                                                @endif
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Number of Employees</th>
                                                        <td>{{ $customer->adminDetail->no_employees ?? '-' }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function scrollToSection(sectionId) {
            document.getElementById(sectionId).scrollIntoView({ behavior: 'smooth' });
        }
        
        // Password strength checker
        document.getElementById('newPassword').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('passwordStrengthBar');
            
            let strength = 0;
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
            if (password.match(/\d/)) strength++;
            if (password.match(/[^a-zA-Z\d]/)) strength++;
            
            strengthBar.className = 'password-strength-bar';
            
            if (strength <= 1) {
                strengthBar.style.width = '25%';
                strengthBar.classList.add('password-strength-weak');
            } else if (strength <= 2) {
                strengthBar.style.width = '50%';
                strengthBar.classList.add('password-strength-medium');
            } else if (strength <= 3) {
                strengthBar.style.width = '75%';
                strengthBar.classList.add('password-strength-medium');
            } else {
                strengthBar.style.width = '100%';
                strengthBar.classList.add('password-strength-strong');
            }
        });
        
        // Password confirmation validation
        document.getElementById('passwordForm').addEventListener('submit', function(e) {
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert('New password and confirm password do not match!');
            }
        });
    </script>
</body>
</html>
@endsection