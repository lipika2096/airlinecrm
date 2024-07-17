<link rel="stylesheet" href="{{asset('public/css/custom-style.css')}}">

@php
    use Carbon\Carbon;
@endphp
<!-- Page Content -->
<div class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="welcome-box">
                <div class="welcome-img">
                    <img alt="" src="{{ auth()->user()->avatar }}" style="height: 60px; width: 60px; border-radius: 8px; float: left; margin: 2px 8px 0px 8px;">
                </div>
                <div class="welcome-det">
                    <h3>Welcome, {{auth()->user()->first_name}} {{auth()->user()->last_name}}</h3>
                    <p>{{ Carbon::now()->format('l, d F Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4">
            <div class="dash-sidebar">
                <section>
                    <h5 class="dash-title">Tickets</h5>
                    <div class="card">
                        <div class="card-body">
                            <div class="time-list">
                                <div class="dash-stats-list">
                                    <h4>{{ $payload['tickets'] }}</h4>
                                    <p>Total Booked Tickets</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
            <div class="dash-sidebar">
                <section>
                    <h5 class="dash-title">Refunds</h5>
                    <div class="card">
                        <div class="card-body">
                            <div class="time-list">
                                <div class="dash-stats-list">
                                    <h4>{{ $payload['refunds'] }}</h4>
                                    <p>Total Refunds</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        {{-- <div class="col-lg-4 col-md-4">
            <div class="dash-sidebar">
                <section>
                    <h5 class="dash-title">Projects</h5>
                    <div class="card">
                        <div class="card-body">
                            <div class="time-list">
                                <div class="dash-stats-list">
                                    <h4>71</h4>
                                    <p>Total Tasks</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div> --}}
    </div>
</div>
<!-- /Page Content -->


<!-- <style>
.row {
    --bs-gutter-x: 1.5rem;
    --bs-gutter-y: 0;
    display: flex;
    flex-wrap: wrap;
    margin-top: calc(-1* var(--bs-gutter-y));
    margin-right: calc(-.5* var(--bs-gutter-x));
    margin-left: calc(-.5* var(--bs-gutter-x));
}

@media (min-width: 768px) {
    .col-md-12 {
        flex: 0 0 auto;
        width: 100%;
    }
}

.welcome-box {
    background-color: #ffffff;
    border-bottom: 1px solid #ededed;
    position: relative;
    margin: -30px -30px 30px;
    padding: 20px;
}

.welcome-box .welcome-img {
    margin-right: 15px;
}

.welcome-box .welcome-img img {
    width: 60px;
    border-radius: 8px;
}

img {
    max-width: 100%;
    height: auto;
    vertical-align: middle;
}

.welcome-box .welcome-det h3 {
    margin-bottom: 10px;
}

h3 {
    font-weight: 500;
    font-size: 24px;
    margin-bottom: 0.5rem;
}

.welcome-box .welcome-det p {
    color: #777;
    font-size: 18px;
    margin-bottom: 0;
}

p {
    margin-bottom: 1rem;
}
</style> -->

