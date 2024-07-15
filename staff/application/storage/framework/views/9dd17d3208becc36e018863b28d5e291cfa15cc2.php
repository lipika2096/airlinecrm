<div class="count-<?php echo e(@count($projects ?? [])); ?>" id="projects-view-wrapper">
    <?php if(@count($projects ?? []) > 0): ?>
    <div class="cards-grid-container row" id="projects-cards-container">
        <?php echo $__env->make('pages.projects.views.cards.layout.ajax', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <td colspan="20">
        <!--load more button-->
        <?php echo $__env->make('misc.load-more-button', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!--/load more button-->
    </td>
    <?php endif; ?> <?php if(@count($projects ?? []) == 0): ?>
    <!--nothing found-->
    <?php echo $__env->make('notifications.no-results-found', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!--nothing found-->
    <?php endif; ?>
</div><?php /**PATH C:\xampp\htdocs\grow\application\resources\views/pages/projects/views/cards/layout/cards.blade.php ENDPATH**/ ?>