@extends('admin/layouts/authentication-main')
@section('content')

    <meta charset="utf-8" />
    <title>Reset Password | CRM admin template"</title>

    <style>
        .toggle-password {
            transition: color 0.3s ease;
        }
        .toggle-password:hover {
            color: #007bff !important;
        }
    </style>

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
                                    <div class="position-relative" style="position: relative;">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password" required minlength="8" style="padding-right: 40px;">
                                        <span class="fa fa-eye-slash toggle-password" id="toggle-password" role="button" tabindex="0" aria-label="Show password" style="position: absolute; right: 15px; top: 12px; cursor: pointer; z-index: 999; pointer-events: auto; color: #6c757d; font-size: 16px;"></span>
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter a password (minimum 8 characters)
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <div class="position-relative" style="position: relative;">
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password" required style="padding-right: 40px;">
                                        <span class="fa fa-eye-slash toggle-password" id="toggle-password-confirmation" role="button" tabindex="0" aria-label="Show password" style="position: absolute; right: 15px; top: 12px; cursor: pointer; z-index: 999; pointer-events: auto; color: #6c757d; font-size: 16px;"></span>
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
                                document.addEventListener('DOMContentLoaded', function() {

                                    // Form validation
                                    (function() {
                                        'use strict';
                                        var form = document.querySelector('.needs-validation');
                                        form.addEventListener('submit', function(event) {
                                            if (form.checkValidity() === false) {
                                                event.preventDefault();
                                                event.stopPropagation();
                                            }
                                            form.classList.add('was-validated');
                                        }, false);
                                    })();

                                    // Toggle password visibility
                                    function togglePasswordVisibility(inputId, iconId) {
                                        var passwordInput = document.getElementById(inputId);
                                        var icon = document.getElementById(iconId);

                                        if (!passwordInput || !icon) {
                                            return;
                                        }

                                        var isHidden = passwordInput.type === 'password';
                                        passwordInput.type = isHidden ? 'text' : 'password';
                                        icon.classList.toggle('fa-eye', isHidden);
                                        icon.classList.toggle('fa-eye-slash', !isHidden);
                                        icon.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
                                    }

                                    function bindToggle(iconId, inputId) {
                                        var icon = document.getElementById(iconId);
                                        if (!icon) return;

                                        icon.addEventListener('click', function() {
                                            togglePasswordVisibility(inputId, iconId);
                                        });

                                        // Keyboard accessibility (Enter/Space)
                                        icon.addEventListener('keydown', function(event) {
                                            if (event.key === 'Enter' || event.key === ' ') {
                                                event.preventDefault();
                                                togglePasswordVisibility(inputId, iconId);
                                            }
                                        });
                                    }

                                    bindToggle('toggle-password', 'password');
                                    bindToggle('toggle-password-confirmation', 'password_confirmation');

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