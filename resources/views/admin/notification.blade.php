<!DOCTYPE html>
<html lang="en">

<head>

    <?= $title_meta ?>


    <?= $this->include('partials/head-css') ?>

</head>

<?= $this->include('partials/body') ?>

<div class="main-wrapper">
<?= $this->include('partials/menu') ?>

    <!-- Page Wrapper -->
            <div class="page-wrapper">
                <div class="content container-fluid">

                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="page-title">Notification</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Notification</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /Page Header -->

                    <div class="row">

                        <!-- Alert -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title mb-0">Alert</div>
                                </div>
                                <div class="card-body">
                                     <a href="javascript: void(0);"  id="alert" class="btn btn-primary waves-effect waves-light">Click me</a>
                                </div>
                            </div>
                        </div>
                        <!-- /Alert -->

                        <!-- Alert -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title mb-0">Confirm</div>
                                </div>
                                <div class="card-body">
                                      <a href="javascript: void(0);"  id="alert-confirm" class="btn btn-primary waves-effect waves-light">Click me</a>
                                </div>
                            </div>
                        </div>
                        <!-- /Alert -->

                        <!-- Alert -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title mb-0">Prompt</div>
                                </div>
                                <div class="card-body">
                                     <a href="javascript: void(0);"  id="alert-prompt" class="btn btn-primary waves-effect waves-light">Click me</a>
                                </div>
                            </div>
                        </div>
                        <!-- /Alert -->

                        <!-- Alert -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title mb-0">Success Alert</div>
                                </div>
                                <div class="card-body">
                                     <a href="javascript: void(0);"  id="alert-success" class="btn btn-primary btn-sm waves-effect waves-light">Click me</a>
                                </div>
                            </div>
                        </div>
                        <!-- /Alert -->

                        <!-- Alert -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title mb-0">Error Alert</div>
                                </div>
                                <div class="card-body">
                                     <a href="javascript: void(0);"  id="alert-error" class="btn btn-primary btn-sm waves-effect waves-light">Click me</a>
                                </div>
                            </div>
                        </div>
                        <!-- /Alert -->

                        <!-- Alert -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title mb-0">Warnng Alert</div>
                                </div>
                                <div class="card-body">
                                     <a href="javascript: void(0);"  id="alert-warning" class="btn btn-primary btn-sm waves-effect waves-light">Click me</a>
                                </div>
                            </div>
                        </div>
                        <!-- /Alert -->

                    </div>

                </div>
            </div>
            <!-- /Page Wrapper -->




<!-- JAVASCRIPT -->
<?= $this->include('partials/vendor-scripts') ?>


</body>

</html>
