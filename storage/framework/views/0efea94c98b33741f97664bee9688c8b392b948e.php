<?php $__env->startSection('vue-js'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php ($lock_access_screen = true); ?>

<div class="inner_main">
    <div class="page_detail">
        <div class="inner_padding">
            <div class="subs_end">
                <h1 class="page_heading mb-3">Access Blocked</h1>
                <p>
                    <?php echo e(!empty($expiry_date_display) ? 'Your access expired on ' . $expiry_date_display . '.' : 'Your subscription or trial period has ended.'); ?>

                </p>
                <p>Choose a plan to continue. Until then, the reports stay locked.</p>
                <a href="<?php echo e($subscription_cta_url ?? '#'); ?>">Subscribe</a>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/ratio-reports/subscription_lock.blade.php ENDPATH**/ ?>