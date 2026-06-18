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
<div class="custom-banner no-bg fw-banner <?php if(!$dataArr['image_path']): ?> fund-portfolio-banner  <?php endif; ?>" <?php if($dataArr['image_path']): ?> style="background-image:url(<?php echo e($dataArr['image_path']); ?>)" <?php endif; ?>>
    <div class="container">
        <div class="banner-align-lft fw-title">
            <h1 class="f-b"><?php echo e($dataArr['title']); ?></h1>
        </div>
        <div class="clear"></div>
    </div>
</div>

<?php if(session()->has('username') && session()->has('useremail') ): ?>
<div id="vue-app">
    <calculators sip_faqs="<?php echo e($dataArr['descp']); ?>" sip_pdf_url="<?php echo e(isset($dataArr['custom_fields']['text_68'])?$dataArr['custom_fields']['text_68']['value']:''); ?>" username="<?php echo e(session()->get('username')); ?>" useremail="<?php echo e(session()->get('useremail')); ?>"></calculators>
</div>
<?php else: ?>
<div class="myplexus-login-page sip-calc-login">
    <div class="login-page">
        <div class="container">
            <div class="login-block bg-gry br-5 box-shadow">
                <div class="login-wrap">
                    <div class="col-lg-5 col-md-6 col-sm-12 m-auto sip-calc-wrapper">
                        <h3>Please Login First To Get Your Result</h3>
                        <div class="sip-calc-loginin-wrap">

                            <div class="sip-calc-social-login">
                                <h6>Log in with</h6>
                                <ul>
                                    <li><a href="<?php echo e(route('web.calculators.social.login','google')); ?>"><?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(asset('themes/frontend/assets/images/gmail-login-img.jpg')).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(asset('themes/frontend/assets/images/gmail-login-img.jpg')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?></a></li>
                                    <li><a href="<?php echo e(route('web.calculators.social.login','facebook')); ?>"><?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(asset('themes/frontend/assets/images/facebook-login-img.jpg')).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(asset('themes/frontend/assets/images/facebook-login-img.jpg')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?></a></li>
                                </ul>
                                <h6>OR</h6>
                            </div>

                            <form action="<?php echo e(route('web.calculators')); ?>" method="POST">
                                <?php echo csrf_field(); ?>

                                <div class="login-field">
                                    <label>Enter your name</label>
                                    <input type="text" id="login_user" name="username" class="box-shadow" placeholder="John Doe" required />
                                </div>
                                <div class="password-field">
                                    <label>Enter your mail</label>
                                    <input type="email" id="login_pass" name="useremail" class="box-shadow" placeholder="Johndoe@mail.com" required />
                                </div>
                                <div class="log-other-opt">
                                    <div class="login-action-btn float-right">
                                        <input type="submit" value="Next" class="text-uppercase btn-bg-2 f-b text-white" />
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </form>
                            
                            <?php if(session()->has('alert')): ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.alert','data' => ['type' => ''.e(session()->get('alert')).'','title' => ''.e(session()->get('title')).'','message' => ''.e(session()->get('message')).'']]); ?>
<?php $component->withName('form.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => ''.e(session()->get('alert')).'','title' => ''.e(session()->get('title')).'','message' => ''.e(session()->get('message')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php endif; ?>
                            
                            <div class="calculator-select-calc" style="display: none;">
                                <img src="../images/select-calc-bg-img.jpg" class="img-fluid">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/frontend/pages/calculators.blade.php ENDPATH**/ ?>