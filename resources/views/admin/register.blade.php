@extends('admin/layouts/head-main')
@section('content')

    <meta charset="utf-8" />
    <title>Register | HRMS admin template</title>
    <?php include 'layouts/title-meta.php'; ?>

    <?php include 'layouts/head-css.php'; ?>
</head>

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
                            <h3 class="account-title">Register</h3>
                            <p class="account-subtitle">Access to our dashboard</p>

                            <!-- Account Form -->
                            <form class="needs-validation custom-form mt-4 pt-2" novalidate action="admin-dashboard.php">
                                <div class="form-group">
                                    <label for="useremail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="useremail" placeholder="Enter email" required>
                                    <div class="invalid-feedback">
                                        Please Enter Email
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="userpassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" placeholder="Enter password" required>
                                    <div class="invalid-feedback">
                                        Please Enter Password
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="userpassword" class="form-label">Repeat Password</label>
                                    <input type="password" class="form-control" id="userpassword" placeholder="Enter password" required>
                                    <div class="invalid-feedback">
                                        Please Enter Repeat Password
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <button class="btn btn-primary account-btn" type="submit">Register</button>
                                </div>
                                <div class="account-footer">
                                    <p>Already have an account? <a href="{{url('/')}}">Login</a></p>
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
