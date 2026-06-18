<?php $__env->startSection('content'); ?>
<!-- start html code -->
<div class="banner" style="background: url(https://myplexus.com/themes/frontend/assets/v1/img/inner_banner.png)">
    <div class="container">
        <h1>Subscription</h1>
    </div>
</div>

    <div class="body_main">
        <div class="container">
            <div class="subs_main">
                <div class="subs_in">
                    <i class="fa fa-exclamation-triangle yellow"></i>  <p>Subscription will expire on <span>00/00/0000</span></p>

                    <!-- <i class="fa fa-exclamation-triangle red"></i>  <p>Subscription is expired </p> -->
                </div>
                <p>Your subscription has expired. Renew now to continue enjoying exclusive contents.</p>
                <div class="subs_amount">
                    <h5>Subscription amount - <span>500</span> Rs.</h5>
                    <h5>Subscription duration - <span>90</span> days</h5>
                    <a href="#">Pay</a>
                </div>
            </div>
        </div>
    </div>
<!-- end html code -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/auth/subcription.blade.php ENDPATH**/ ?>