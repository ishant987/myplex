<?php $__env->startSection('content'); ?>
<div class="inner_main">
    <div class="page_detail">
        <div class="inner_padding">
            <div class="head_brdcm">
                <ul class="brdcmb">
                    <li><a href="<?php echo e(route('user.auth-dashboard')); ?>">dashboard</a></li>
                    <li>Model Portfolio</li>
                </ul>
            </div>

            <div class="perform_head">
                <h2>Model Portfolio</h2>
            </div>

            <div style="background: linear-gradient(135deg, #f6fbf7 0%, #e6f4eb 100%); border: 1px solid #d9eadf; border-radius: 24px; padding: 48px 32px; text-align: center; box-shadow: 0 20px 50px rgba(34, 73, 52, 0.08);">
                <div style="width: 110px; height: 110px; margin: 0 auto 24px; border-radius: 50%; background: #fff; display: flex; align-items: center; justify-content: center; box-shadow: 0 16px 36px rgba(56, 128, 85, 0.15);">
                    <img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/model.png')); ?>" alt="Model Portfolio" style="width: 54px; height: 54px; object-fit: contain;">
                </div>

                <p style="font-size: 13px; letter-spacing: 0.18em; text-transform: uppercase; color: #379962; margin-bottom: 14px; font-weight: 600;">Coming Soon</p>
                <h3 style="font-size: 38px; line-height: 1.2; color: #1f2f26; margin-bottom: 16px; font-weight: 700;">Stay tuned</h3>
                <p style="max-width: 760px; margin: 0 auto; font-size: 20px; line-height: 1.7; color: #506358;">
                    Future prediction of model portfolios is coming soon. We are preparing a smarter experience to help you explore upcoming portfolio ideas with more confidence.
                </p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/model_portfolio/index.blade.php ENDPATH**/ ?>