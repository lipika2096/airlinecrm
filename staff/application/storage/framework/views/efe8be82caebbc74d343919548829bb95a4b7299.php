<div class="row">
<div class="col-lg-3 col-md-6">
    <div class="card">
        <div class="card-body p-l-15 p-r-15">
            <div class="d-flex p-10 no-block">
                <span class="align-slef-center">
                    <h2 class="m-b-0"><?php echo e($payload['tickets']); ?></h2>
                    <h6 class="text-muted m-b-0">Tickets</h6>
                </span>
                <div class="align-self-center display-6 ml-auto"><i class="text-info icon-Ticket"></i></div>
            </div>
        </div>
        <div class="progress">
            <div class="progress-bar bg-success w-100 h-px-3" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                aria-valuemax="100"></div>
        </div>
    </div>
</div>

<!-- Bookings Count -->
<div class="col-lg-3 col-md-6">
    <div class="card">
        <div class="card-body p-l-15 p-r-15">
            <div class="d-flex p-10 no-block">
                <span class="align-slef-center">
                    <h2 class="m-b-0"><?php echo e($payload['bookings']); ?></h2>
                    <h6 class="text-muted m-b-0">Bookings</h6>
                </span>
                <div class="align-self-center display-6 ml-auto"><i class="text-info icon-Credit-Card2"></i></div>
            </div>
        </div>
        <div class="progress">
            <div class="progress-bar bg-warning w-100 h-px-3" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                aria-valuemax="100"></div>
        </div>
    </div>
</div>

<!-- Leads Count -->
<div class="col-lg-3 col-md-6">
    <div class="card">
        <div class="card-body p-l-15 p-r-15">
            <div class="d-flex p-10 no-block">
                <span class="align-slef-center">
                    <h2 class="m-b-0"><?php echo e($payload['leads']); ?></h2>
                    <h6 class="text-muted m-b-0">Leads</h6>
                </span>
                <div class="align-self-center display-6 ml-auto"><i class="text-info icon-Credit-Card2"></i></div>
            </div>
        </div>
        <div class="progress">
            <div class="progress-bar bg-danger w-100 h-px-3" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                aria-valuemax="100"></div>
        </div>
    </div>
</div>

<!-- Refunds Count -->
<div class="col-lg-3 col-md-6">
    <div class="card">
        <div class="card-body p-l-15 p-r-15">
            <div class="d-flex p-10 no-block">
                <span class="align-slef-center">
                    <h2 class="m-b-0"><?php echo e($payload['refunds']); ?></h2>
                    <h6 class="text-muted m-b-0">Refunds</h6>
                </span>
                <div class="align-self-center display-6 ml-auto"><i class="text-info icon-Credit-Card2"></i>
                </div>
            </div>
        </div>
        <div class="progress">
            <div class="progress-bar bg-success w-100 h-px-3" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                aria-valuemax="100"></div>
        </div>
    </div>
</div>
</div><?php /**PATH /home/pentasof/hrcrm.testpentas.in/agent/application/resources/views/pages/home/client/widgets/first-row/wrapper.blade.php ENDPATH**/ ?>