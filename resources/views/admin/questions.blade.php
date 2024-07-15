@extends('admin/layouts/head-main')
@section('content')


    <title>Questions</title>


  <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Aptitude</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item ">Jobs</li>
                            <li class="breadcrumb-item">Interviewing</li>
                            <li class="breadcrumb-item active">Aptitude</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Content Starts -->
            <div class="card">
                <div class="card-body">
                    <!-- <h4 class="card-title">Solid justified</h4> -->
                    <ul class="nav nav-tabs nav-tabs-solid nav-justified">
                        <li class="nav-item"><a class="nav-link" href="user-dashboard.php">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="user-all-jobs.php">All </a></li>
                        <li class="nav-item"><a class="nav-link" href="saved-jobs.php">Saved</a></li>
                        <li class="nav-item"><a class="nav-link" href="applied-jobs.php">Applied</a></li>
                        <li class="nav-item"><a class="nav-link active" href="interviewing.php">Interviewing</a></li>
                        <li class="nav-item"><a class="nav-link" href="offered-jobs.php">Offered</a></li>
                        <li class="nav-item"><a class="nav-link" href="visited-jobs.php">Visitied </a></li>
                        <li class="nav-item"><a class="nav-link" href="archived-jobs.php">Archived </a></li>
                    </ul>
                </div>
            </div>


                    <div class="quiz-wizard">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="card">
                            <div class="card-body">
                                <div class="" id="myWizard">
                                    <div style="display:none;" class="navbar">
                                        <div class="navbar-inner">
                                            <ul class="nav nav-pills">
                                                <li class="active"><a href="#step1" data-bs-toggle="tab" data-step="1">Step 1</a></li>
                                                <li class=""><a href="#step2" data-bs-toggle="tab" data-step="2">Step 2</a></li>
                                                <li class=""><a href="#step3" data-bs-toggle="tab" data-step="3">Step 3</a></li>
                                                <li class=""><a href="#step4" data-bs-toggle="tab" data-step="4">Step 4</a></li>
                                                <li class=""><a href="#step5" data-bs-toggle="tab" data-step="5">Step 5</a></li>
                                                <li class=""><a href="#step6" data-bs-toggle="tab" data-step="6">Step 6</a></li>
                                                <li class=""><a href="#step7" data-bs-toggle="tab" data-step="7">Step 7</a></li>
                                                <li class=""><a href="#step8" data-bs-toggle="tab" data-step="8">Step 8</a></li>
                                                <li class=""><a href="#step9" data-bs-toggle="tab" data-step="9">Step 9</a></li>
                                                <li class=""><a href="#step10" data-bs-toggle="tab" data-step="10">Step 10</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <form method="post" id="quiz_answer">
                                        <div class="tab-content pt-0">
                                            <div class="tab-pane active" id="step1">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="">
                                                            <h4 class="mb-4 text-dark"><span>1.</span> IS management has decided to rewrite a legacy customer relations system using fourth generation languages (4GLs). Which of the following risks is MOST often associated with system development using 4GLs?</h4>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label class="question-radio text-secondary">
                                                                    <input type="radio" name="answer[10]">
                                                                    <span class="checkmark"></span>
                                                                    Inadequate screen/report design facilities
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="question-radio text-secondary">
                                                                    <input type="radio" name="answer[10]">
                                                                    <span class="checkmark"></span>
                                                                    Complex programming language subsets
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="question-radio text-secondary">
                                                                    <input type="radio" name="answer[10]">
                                                                    <span class="checkmark"></span>
                                                                    Lack of portability across operating systems
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="question-radio text-secondary">
                                                                    <input type="radio" name="answer[10]">
                                                                    <span class="checkmark"></span>
                                                                    Inability to perform data intensive operations
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-start mt-3">
                                                            <a class="btn btn-primary btn-lg next submit-btn" href="#">Next</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="step2">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="">
                                                            <h4 class="mb-4 text-dark"><span>2.</span> Which of the following would be the BEST method for ensuring that critical fields in a master record have been updated properly?</h4>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label class="question-radio text-secondary">
                                                                    <input type="radio" name="answer[11]">
                                                                    <span class="checkmark"></span>
                                                                    Inadequate screen/report design facilities
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="question-radio text-secondary">
                                                                    <input type="radio" name="answer[11]">
                                                                    <span class="checkmark"></span>
                                                                    Complex programming language subsets
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="question-radio text-secondary">
                                                                    <input type="radio" name="answer[11]">
                                                                    <span class="checkmark"></span>
                                                                    Lack of portability across operating systems
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="question-radio text-secondary">
                                                                    <input type="radio" name="answer[11]">
                                                                    <span class="checkmark"></span>
                                                                    Inability to perform data intensive operations
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-start mt-3">
                                                            <a class="btn btn-primary btn-lg next submit-btn" href="#">Next</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade in " id="step3">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="">
                                                            <h4 class="mb-4 text-dark"><span>3.</span> Which of the following is a dynamic analysis tool for the purpose of testing software modules?</h4>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label class="question-radio text-secondary">
                                                                    <input type="radio" name="answer[12]">
                                                                    <span class="checkmark"></span>
                                                                    Blackbox test
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="question-radio text-secondary">
                                                                    <input type="radio" name="answer[12]">
                                                                    <span class="checkmark"></span>
                                                                    Desk checking
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="question-radio text-secondary">
                                                                    <input type="radio" name="answer[12]">
                                                                    <span class="checkmark"></span>
                                                                    Structured walk-through
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="question-radio text-secondary">
                                                                    <input type="radio" name="answer[12]">
                                                                    <span class="checkmark"></span>
                                                                    Design and code
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-start mt-3">
                                                            <a class="btn btn-primary btn-lg next submit-btn" href="#">Next</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade in " id="step4">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="">
                                                            <h4 class="mb-4 text-dark"><span>4.</span> Which of the following is MOST likely to result from a business process reengineering (BPR) project?</h4>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label class="question-radio text-secondary">
                                                                    <input type="radio" name="answer[13]">
                                                                    <span class="checkmark"></span>
                                                                    An increased number of people using technology
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="question-radio text-secondary">
                                                                    <input type="radio" name="answer[13]">
                                                                    <span class="checkmark"></span>
                                                                    Significant cost savings, through a reduction in the complexity of information technology
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="question-radio text-secondary">
                                                                    <input type="radio" name="answer[13]">
                                                                    <span class="checkmark"></span>
                                                                    A weaker organisational structures and less accountability
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="question-radio text-secondary">
                                                                    <input type="radio" name="answer[13]">
                                                                    <span class="checkmark"></span>
                                                                    Increased information protection (IP) risk will increase
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-start mt-3">
                                                            <a class="btn btn-primary btn-lg next submit-btn" href="#">Next</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade in " id="step5">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="">
                                                            <h4 class="mb-4 text-dark"><span>5.</span> Which of the following devices extends the network and has the capacity to store frames and act as a storage and forward device?</h4>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label class="question-radio text-secondary">
                                                                    <input type="radio" name="answer[14]">
                                                                    <span class="checkmark"></span>
                                                                    Gateway
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="question-radio text-secondary">
                                                                    <input type="radio" name="answer[14]">
                                                                    <span class="checkmark"></span>
                                                                    Repeater
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="question-radio text-secondary">
                                                                    <input type="radio" name="answer[14]">
                                                                    <span class="checkmark"></span>
                                                                    Bridge
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="question-radio text-secondary">
                                                                    <input type="radio" name="answer[14]">
                                                                    <span class="checkmark"></span>
                                                                    Router
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-start mt-3">
                                                            <a class="btn btn-primary btn-lg next submit-btn" href="#">Next</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade in " id="step10">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="">
                                                            <h4 class="mb-4 text-dark"><span>6.</span> An offsite information processing facility having electrical wiring, air conditioning and flooring, but no computer or communications equipment is a:</h4>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label class="question-radio text-secondary">
                                                                    <input type="radio" name="answer[15]">
                                                                    <span class="checkmark"></span>
                                                                    Cold site
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="question-radio text-secondary">
                                                                    <input type="radio" name="answer[15]">
                                                                    <span class="checkmark"></span>
                                                                    Warm site
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="question-radio text-secondary">
                                                                    <input type="radio" name="answer[15]">
                                                                    <span class="checkmark"></span>
                                                                    Dial-up site
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="question-radio text-secondary">
                                                                    <input type="radio" name="answer[15]">
                                                                    <span class="checkmark"></span>
                                                                    Duplicate processing facility
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-success btn-lg submit-btn mt-3" data-bs-toggle="modal" data-bs-target="#free_question_modal" type="button">Finish</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <!-- /Content End -->

        </div>
        <!-- /Page Content -->

    </div>
    <!-- /Page Wrapper -->


        <div class="modal question-modal" id="free_question_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered  " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="mb-0">Result for Your Questions</h3>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="form-horzontal">
                    <div class="col-md-12">
                        <div class="text-start mb-3">
                            <h3 class="mb-0">Correct Answers : <span class="text-success"><b>5</b></span></h3>
                        </div>
                        <div class="text-start">
                            <h3 class="mb-0">Wrong Answer : <span class="text-danger"><b>1</b></span></h3>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                <p>Please click Next to move main menu.</p>
                <a href="job-aptitude.php" class="btn btn-primary btn-lg submit-btn d-block">Next</a>
            </div>
            </div>

        </div>
    </div>
</div>





@endsection
