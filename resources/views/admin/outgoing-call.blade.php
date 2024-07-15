@extends('admin/layouts/head-main')
@section('content')


    <title>Outgoing Call</title>


<body>
  <div class="main-wrapper">
@include('admin/layouts/topbar')
@include('admin/layouts/chat_sidebar')
@include('admin/layouts/two-col-sidebar')


<!-- Page Wrapper -->
            <div class="page-wrapper">

                <!-- Outgoing Call -->
                <div class="call-box outgoing-box">
                    <div class="call-wrapper">
                        <div class="call-inner">
                            <div class="call-user">
                                <img alt="" src="{{asset('public/assets/img/profiles/avatar-02.jpg')}}" class="call-avatar">
                                <h4>John Doe</h4>
                                <span>Connecting...</span>
                            </div>
                            <div class="call-items">
                                <a href="javascript:void(0);" class="btn call-item"><i class="material-icons">mic</i></a>
                                <a href="javascript:void(0);" class="btn call-item"><i class="material-icons">videocam</i></a>
                                <a href="apps-chat" class="btn call-item call-end"><i class="material-icons vcend">call_end</i></a>
                                <a href="javascript:void(0);" class="btn call-item"><i class="material-icons">person_add</i></a>
                                <a href="javascript:void(0);" class="btn call-item"><i class="material-icons">volume_up</i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Outgoing Call -->

            </div>
            <!-- /Page Wrapper -->





@endsection
