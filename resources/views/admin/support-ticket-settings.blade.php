@extends('admin/layouts/authentications-main')
@section('content')

    <title>Support Ticket Settings</title>
    <div class="main-wrapper">
    @include('admin/layouts/topbar')
    @include('admin/layouts/settings-sidebar')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="row">
                <div class="col-md-8 offset-md-2">

                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="page-title">Support Ticket Settings</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /Page Header -->

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('admin.support-ticket-settings.update') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label>Enable Auto-Close Tickets</label><br>
                            <label class="switch">
                                <input type="hidden" value="0" name="auto_close_enabled">
                                <input type="checkbox" {{ $settings->auto_close_enabled ? 'checked' : '' }} name="auto_close_enabled" value="1">
                                <span></span>
                            </label>
                            <small class="form-text text-muted">Automatically close support tickets after specified hours</small>
                        </div>

                        <div class="form-group">
                            <label>Auto-Close Hours <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="auto_close_hours" value="{{ $settings->auto_close_hours }}" min="1" max="8760" required>
                            <small class="form-text text-muted">Number of hours after which tickets should be auto-closed (1-8760 hours)</small>
                        </div>

                        <div class="form-group">
                            <label>Auto-Close Statuses</label>
                            <small class="form-text text-muted">Select the ticket statuses that should trigger auto-close</small>
                            <div class="mt-2">
                                @foreach($ticketStatuses as $status)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               name="auto_close_statuses[]" 
                                               value="{{ $status->slug }}"
                                               id="status_{{ $status->slug }}"
                                               {{ in_array($status->slug, $settings->getAutoCloseStatusesArrayAttribute()) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_{{ $status->slug }}">
                                            {{ $status->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

    </div>
    <!-- /Page Wrapper -->



@endsection
