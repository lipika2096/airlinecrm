@extends('admin/layouts/head-main')
@section('content')


    <title>Incoming Call</title>

    <div class="main-wrapper">
@include('admin/layouts/topbar')
@include('admin/layouts/chat_sidebar')
@include('admin/layouts/two-col-sidebar')

    <!-- Page Wrapper -->
            <div class="page-wrapper">

                <!-- Incoming Call -->
                <div class="call-box incoming-box">
                    <div class="call-wrapper">
                        <div class="call-inner">
                            <div class="call-user">
                                <img class="call-avatar" src="{{asset('public/assets/img/profiles/avatar-11.jpg')}}" alt="">
                                <h4>Wilmer Deluna</h4>
                                <span>Calling ...</span>
                            </div>
                            <div class="call-items">
                                <a href="chat.php" class="btn call-item call-end"><i class="material-icons">call_end</i></a>
                                <a href="video-call.php" class="btn call-item call-start"><i class="material-icons">call</i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Incoming Call -->

            </div>
            <!-- /Page Wrapper -->





@endsection
