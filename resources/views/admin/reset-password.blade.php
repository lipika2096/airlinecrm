@extends('admin/layouts/authentication-main')
@section('content')

    <meta charset="utf-8" />
    <title>Reset Password | CRM admin template"</title>


      <!-- Main Wrapper -->
        <div class="main-wrapper">

            <div class="account-content">
                <div class="container">

                    <!-- Account Logo -->
                    <div class="account-logo">
                        <a href="#"><img src="{{asset('public/assets/img/logo2.png')}}" alt="Dreamguy's Technologies"></a>
                    </div>
                    <!-- /Account Logo -->

                    <div class="account-box">
                        <div class="account-wrapper">
                            <h3 class="account-title">Reset Password</h3>
                            <p class="account-subtitle">Enter your new password below</p>

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <!-- Account Form -->
                            <form class="needs-validation custom-form mt-4 pt-2" method="POST" action="{{ url('/reset-password') }}" novalidate>
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <input type="hidden" name="email" value="{{ $email }}">
                                
                                <div class="form-group">
                                    <label for="password" class="form-label">New Password</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password" required minlength="8">
                                        <span class="fa fa-eye-slash" id="toggle-password" style="position: absolute; right: 15px; top: 12px; cursor: pointer;"></span>
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter a password (minimum 8 characters)
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password" required>
                                        <span class="fa fa-eye-slash" id="toggle-password-confirmation" style="position: absolute; right: 15px; top: 12px; cursor: pointer;"></span>
                                    </div>
                                    <div class="invalid-feedback">
                                        Please confirm your password
                                    </div>
                                </div>
                                
                                <div class="form-group text-center">
                                    <button class="btn btn-primary account-btn" type="submit">Reset Password</button>
                                </div>
                                <div class="account-footer">
                                    <p>Remember your password? <a href="{{url('/')}}">Login</a></p>
                                </div>
                            </form>
                            <!-- /Account Form -->

                            <script>
                                // Form validation
                                (function() {
                                    'use strict';
                                    window.addEventListener('load', function() {
                                        var form = document.querySelector('.needs-validation');
                                        form.addEventListener('submit', function(event) {
                                            if (form.checkValidity() === false) {
                                                event.preventDefault();
                                                event.stopPropagation();
                                            }
                                            form.classList.add('was-validated');
                                        }, false);
                                    });
                                })();

                                // Toggle password visibility
                                document.getElementById('toggle-password').addEventListener('click', function() {
                                    var passwordInput = document.getElementById('password');
                                    var icon = this;
                                    if (passwordInput.type === 'password') {
                                        passwordInput.type = 'text';
                                        icon.classList.remove('fa-eye-slash');
                                        icon.classList.add('fa-eye');
                                    } else {
                                        passwordInput.type = 'password';
                                        icon.classList.remove('fa-eye');
                                        icon.classList.add('fa-eye-slash');
                                    }
                                });

                                document.getElementById('toggle-password-confirmation').addEventListener('click', function() {
                                    var passwordInput = document.getElementById('password_confirmation');
                                    var icon = this;
                                    if (passwordInput.type === 'password') {
                                        passwordInput.type = 'text';
                                        icon.classList.remove('fa-eye-slash');
                                        icon.classList.add('fa-eye');
                                    } else {
                                        passwordInput.type = 'password';
                                        icon.classList.remove('fa-eye');
                                        icon.classList.add('fa-eye-slash');
                                    }
                                });
                            </script>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Main Wrapper -->



    </body>

</html>