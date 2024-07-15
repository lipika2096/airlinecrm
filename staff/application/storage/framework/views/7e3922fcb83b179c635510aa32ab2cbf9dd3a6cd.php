<!--each reply-->
<?php $__currentLoopData = $replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="comment-widgets">
    <div class="d-flex flex-row comment-rowp-b-0">
        <div class="p-2"><span class="round"><img src="<?php echo e(getUsersAvatar($reply->avatar_directory, $reply->avatar_filename)); ?>"
                    width="50"></span></div>
        <div class="comment-text w-100">
            <h5 class="m-b-0"><?php echo e($reply->first_name ?? runtimeUnkownUser()); ?></h5>
            <div class="text-muted m-b-5"><small class="text-muted"><?php echo e(runtimeDateAgo($reply->ticketreply_created)); ?></small></div>
            <?php echo clean($reply->ticketreply_text); ?>


            <div class="comment-footer text-right">
                <small class="text-muted"><?php echo e(runtimeDate($reply->ticketreply_created)); ?> <?php echo e(cleanLang(__('lang.at'))); ?> <?php echo e(runtimeTime($reply->ticketreply_created)); ?></small>
            </div>


        </div>
    </div>

    <!--ticket attachements-->
    <?php if($reply->attachments_count > 0): ?>
    <div class="x-attachements">
        <!--attachments container-->
        <div class="row">
            <!--attachments-->
            <?php $__currentLoopData = $reply->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('pages.ticket.components.attachments', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /home/pentasof/hrcrm.testpentas.in/staff/application/resources/views/pages/ticket/components/replies.blade.php ENDPATH**/ ?>