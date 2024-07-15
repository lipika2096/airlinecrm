@extends('admin/layouts/head-main')
@section('content')

    <meta charset="utf-8" />
    <title>Recover Password | HRMS admin template</title>


    <?php include 'layouts/body.php'; ?>
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
                            <h3 class="account-title">Forgot Password?</h3>
                            <p class="account-subtitle">Enter your email to get a password reset link</p>

                            <!-- Account Form -->
                            <form class="needs-validation custom-form mt-4 pt-2" novalidate>
                                <div class="form-group">
                                    <label for="useremail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="useremail" placeholder="Enter email" required>
                                    <div class="invalid-feedback">
                                        Please Enter Email
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

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Main Wrapper -->


        <!-- JAVASCRIPT -->
        <?php include 'layouts/vendor-scripts.php'; ?>

    </body>

</html>
