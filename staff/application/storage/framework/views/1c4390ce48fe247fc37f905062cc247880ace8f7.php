<div class="row">
    <!--options panel-->
    <?php echo $__env->make('pages.ticket.components.panel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <div class="col-sm-12 col-lg-9">

        <!--body-->
        <div class="card-body card x-message p-t-0" id="ticket-body">
            <!--message-->
            <div class="x-body">
                <div class="d-flex m-b-20">
                    <div>
                        <img src="<?php echo e(getUsersAvatar($ticket->avatar_directory, $ticket->avatar_filename)); ?>" alt="user"
                            width="40" class="img-circle" />
                    </div>
                    <div class="p-l-10">
                        <h5 class="m-b-0"><?php echo e($ticket->first_name ?? runtimeUnkownUser()); ?></h5>
                        <small class="text-muted"><?php echo e(runtimeDateAgo($ticket->ticket_created )); ?></small>
                    </div>
                </div>

                <?php echo clean($ticket->ticket_message); ?>


            </div>
            <!--ticket attachements-->
            <?php if($ticket->attachments_count > 0): ?>
            <div class="x-attachements">
                <!--attachments container-->
                <div class="row">
                    <!--attachments-->
                    <?php $__currentLoopData = $ticket->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('pages.ticket.components.attachments', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>


        <!--replies-->
        <div id="ticket-replies-container">
            <?php echo $__env->make('pages.ticket.components.replies', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <!--reply notice-->
        <?php if(config('visibility.ticket_replying_on_hold')): ?>
        <div class="p-b-40">
            <div class="alert alert-danger" id="ticket_reply_onhold_notice"><?php echo e(cleanLang(__('lang.ticket_is_on_hold'))); ?></div>
        </div>
        <?php endif; ?>

        <!--reply button-->
        <?php if(config('visibility.ticket_replying')): ?>
        <div class="p-b-40">
            <div class="x-reply text-center" id="ticket_reply_button">
                <button type="button" class="btn btn-rounded-x btn-info edit-add-modal-button js-ajax-ux-request"
                    data-toggle="modal" data-url="<?php echo e(urlResource('/tickets/'.$ticket->ticket_id.'/reply')); ?>"
                    data-action-url="<?php echo e(urlResource('/tickets/'.$ticket->ticket_id.'/postreply')); ?>"
                    data-target="#commonModal" data-loading-target="commonModalBody" data-action-method="POST"
                    data-modal-title="<?php echo e(cleanLang(__('lang.reply_ticket'))); ?>">
                    <?php echo e(cleanLang(__('lang.reply_ticket'))); ?></button>
            </div>
        </div>
        <?php endif; ?>


    </div>

</div><?php /**PATH C:\xampp\htdocs\hrcrm\staff\application\resources\views/pages/ticket/components/body.blade.php ENDPATH**/ ?>