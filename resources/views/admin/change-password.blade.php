@extends('admin/layouts/authentications-main')
@section('title', 'Change Password')
@section('content')


        <!-- Main Wrapper -->

            <div class="main-wrapper">
                <div class="account-content">
                    <!-- Account Logo -->
                    <div class="account-logo">
                        <a href="admin-dashboard.html"><img src="{{asset('public/assets/img/logo2.png')}}" alt="Dreamguy's Technologies"></a>
                    </div>
                    <div class="account-box">
                        <div class="account-wrapper">
                            <h3 class="account-title">Change Password</h3>
                            <form>
                                <div class="form-group">
                                    <label>Old password</label>
                                    <input type="password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>New password</label>
                                    <input type="password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Confirm password</label>
                                    <input type="password" class="form-control">
                                </div>
                                <div class="submit-section mb-4">
                                    <button class="btn btn-primary submit-btn">Update Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Two Col Sidebar --><!-- Page Wrapper -->

        <!-- /Main Wrapper -->

        <?php include 'layouts/vendor-scripts.php'; ?>

    </body>

</html>
