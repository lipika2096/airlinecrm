<?php include 'layouts/session.php'; ?>
<?php include 'layouts/head-main.php'; ?>

    <head>

        <title>Login</title>
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

                            <!-- Lock User Img -->
                            <div class="lock-user">
                                <img alt="" src="{{asset('public/assets/img/profiles/avatar-02.jpg')}}" class="rounded-circle">
                                <h4>John Doe</h4>
                            </div>
                            <!-- /Lock User Img -->

                            <!-- Account Form -->
                            <form action="admin-dashboard.php">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" type="password">
                                </div>
                                <div class="form-group text-center">
                                    <button class="btn btn-primary account-btn" type="submit">Enter</button>
                                </div>
                                <div class="account-footer">
                                    <p>Sign in as a different user? <a href="{{url('/')}}">Login</a></p>
                                </div>
                            </form>
                            <!-- /Account Form -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Main Wrapper -->

        <?php include 'layouts/vendor-scripts.php'; ?>

    </body>

</html>
