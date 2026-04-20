<?php $__env->startSection('vue-js'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="inner_main">
    <div class="page_detail">
        <div class="inner_padding">
            <div class="perform">
                <div class="head_brdcm">
                    <h1 class="page_heading"><?php echo e($page_title); ?></h1>
                    <ul class="brdcmb">
                        <li><a href="<?php echo e(route('user.ratio_dashboard')); ?>">Ratio Reports</a></li>
                        <li><?php echo e($page_title); ?></li>
                    </ul>
                </div>
                <div class="subs_end">
                    <p><?php echo e($page_message); ?></p>
                    <a href="<?php echo e(route('user.ratio_dashboard')); ?>">Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/ratio-reports/generic_page.blade.php ENDPATH**/ ?>