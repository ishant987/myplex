<?php $__env->startSection('captcha'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('jquery-validate'); ?> <?php $__env->stopSection(); ?>
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
<?php $__env->startPush('styles'); ?>
<style>
    .custom-banner {
        background-image: url('<?php echo e($dataArr['image_path']); ?>');
    }
</style>
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php if($dataArr['full_url']): ?>
<?php $__env->startSection('cur-url'); ?><?php echo e($dataArr['full_url']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php $__env->startSection('content'); ?>
<div class="custom-banner no-bg about-us-banner">
    <div class="container">
        <?php if(isset($dataArr['custom_fields']['textarea_29'])): ?>
        <h1 class="f-b"><?php echo nl2br($dataArr['custom_fields']['textarea_29']['value']); ?></h1>
        <?php endif; ?>
    </div>
</div>

<div class="opinions-funds bg-gry">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-12 opinions-funds-title">
                <?php echo $dataArr['descp']; ?>

            </div>
        </div>
    </div>
</div>

<div class="opinions-wrap">
    <div class="container">
        <?php if(count($fundSgsListMdl) > 0): ?>
        <?php $__currentLoopData = $fundSgsListMdl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="opinions-blocks br-5 border-s bg-gry box-shadow">
            <div class="row">
                <div class="col-lg-9 col-md-8 col-sm-12 op-title">
                    <h5><?php echo e($record->title); ?></h5>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-12 op-download">
                    <?php if($record->file): ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e($defDataArr['media_folder'].$record->file).'','target' => '_blank']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e($defDataArr['media_folder'].$record->file).'','target' => '_blank']); ?><?php echo e(__('web.download_pdf_txt')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="opinions-content">
                <?php echo $record->description; ?>

            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>
</div>
<?php echo $__env->make('themes.frontend.includes.patshala-newsletter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/frontend/pages/thoughts-and-opinion-on-funds.blade.php ENDPATH**/ ?>