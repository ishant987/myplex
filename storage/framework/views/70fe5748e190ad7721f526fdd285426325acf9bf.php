<?php $__env->startSection('captcha'); ?> <?php $__env->stopSection(); ?>
<?php if(isset($dataArr['meta_title'])): ?>
<?php $__env->startSection('page-title'); ?><?php echo e($dataArr['meta_title']); ?><?php $__env->stopSection(); ?>
<?php else: ?>
<?php $__env->startSection('page-title'); ?><?php echo e($dataArr['title']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php if(isset($dataArr['meta_key'])): ?>
<?php $__env->startSection('meta-keywords'); ?><?php echo e($dataArr['meta_key']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php if(isset($dataArr['meta_descp'])): ?>
<?php $__env->startSection('meta-description'); ?><?php echo e($dataArr['meta_descp']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php if(isset($dataArr['image_path'])): ?>
<?php $__env->startSection('meta-image'); ?><?php echo e($dataArr['image_path']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php if($dataArr['full_url']): ?>
<?php $__env->startSection('cur-url'); ?><?php echo e($dataArr['full_url']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>

<?php $__env->startSection('vue-js'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<section class="inner_banner_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="inner_section_banner">
                    <h4>Retirement Calculator</h4>
                    <p>
                        
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if(session()->has('username') && session()->has('useremail') ): ?>

<div id="vue-app">
    <retirement-calculator image_path="<?php echo e(asset('themes/frontend/assets/v1/img/')); ?>" sip_faqs="" sip_pdf_url="<?php echo e(isset($dataArr['custom_fields']['text_68'])?$dataArr['custom_fields']['text_68']['value']:''); ?>" username="<?php echo e(session()->get('username')); ?>" useremail="<?php echo e(session()->get('useremail')); ?>"></retirement-calculator>
</div>
<?php else: ?>
<section >
    <div class="container">
        <div class="row" style="display: flex;justify-content: center;align-items: center;">
            <div class="col-md-4" > 
                <?php echo $__env->make('web.common.login',['source'=>'calucator'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        $('.cal_sign_in').click(function(){
            $('.login_form').submit();
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/pages/calulators/retirement_calulator.blade.php ENDPATH**/ ?>