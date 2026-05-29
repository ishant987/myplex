<?php $__env->startSection('vue-js'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="inner_main">
    <div class="page_detail">
        <div class="inner_padding">
            <div class="subs_end">
                <p>Your subscription has expired. Renew now to continue enjoying exclusive contents. </p>
                <a href="<?php echo e(route('web.subscriptions.index')); ?>">Subscribe</a>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/ratio-reports/subscription_lock.blade.php ENDPATH**/ ?>