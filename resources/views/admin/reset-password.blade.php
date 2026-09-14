@extends('admin/layouts/authentication-main')
@section('content')

    <meta charset="utf-8" />
    <title>Reset Password | CRM admin template"</title>

    <style>
        .show-passwords-container {
            margin-top: 10px;
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
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password" required minlength="8">
                                    <div class="invalid-feedback">
                                        Please enter a password (minimum 8 characters)
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password" required>
                                    <div class="invalid-feedback">
                                        Please confirm your password
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="show-passwords" name="show-passwords">
                                        <label class="form-check-label" for="show-passwords">
                                            Show passwords
                                        </label>
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
                                    console.log('DOM loaded, initializing password toggle functionality');

                                    // Form validation
                                    (function() {
                                        'use strict';
                                        var form = document.querySelector('.needs-validation');
                                        if (form) {
                                            form.addEventListener('submit', function(event) {
                                                if (form.checkValidity() === false) {
                                                    event.preventDefault();
                                                    event.stopPropagation();
                                                }
                                                form.classList.add('was-validated');
                                            }, false);
                                        }
                                    })();

                                    // Show/Hide passwords for both fields using checkbox
                                    var showPasswordsCheckbox = document.getElementById('show-passwords');
                                    var passwordInput = document.getElementById('password');
                                    var confirmInput = document.getElementById('password_confirmation');

                                    if (showPasswordsCheckbox && passwordInput && confirmInput) {
                                        showPasswordsCheckbox.addEventListener('change', function() {
                                            var showPasswords = this.checked;
                    
                    // Toggle both password fields
                    passwordInput.type = showPasswords ? 'text' : 'password';
                    confirmInput.type = showPasswords ? 'text' : 'password';
                    
                    console.log('Passwords visibility:', showPasswords ? 'shown' : 'hidden');
                });
                
                console.log('Password checkbox toggle functionality initialized');
            } else {
                console.error('Required elements not found for password toggle');
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