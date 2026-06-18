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
<div class="custom-banner no-bg fw-banner mutual-fund-class-banner">
    <div class="container">
        <h1 class="f-b"><?php echo nl2br($dataArr['title']); ?></h1>
    </div>
</div>

<div class="mutual-f-taxation mutual-f-class bg-gry">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-5 col-md-5 col-sm-12 mutual-f-class-lft">
                <h3><?php echo e($fundClsMdl->title); ?></h3>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mutual-f-class-rgt">
                <?php if(count($fundClsListMdl) > 0): ?>
                <ul class="nav nav-tabs">
                    <?php $__currentLoopData = $fundClsListMdl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li <?php echo e(($record->fc_id == $fundClsMdl->fc_id)?'class=active':''); ?>>
                        <a href="<?php echo e(route('web.mutualfundclassifications', $record->fc_id)); ?>" <?php echo e(($record->fc_id == $fundClsMdl->fc_id)?'class=active':''); ?>><?php echo e($record->title); ?></a>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php if($fundClsMdl->file): ?>
<div class="mutual-fund-pdf-wrap">
    <div class="container">
        <div class="inner-pdf-wrap br-5 border-s box-shadow">
            <embed src="<?php echo e($defDataArr['media_folder'].$fundClsMdl->file); ?>" type="application/pdf" width="100%" height="500px">
        </div>
    </div>
</div>
<?php endif; ?>
<?php echo $__env->make('themes.frontend.includes.patshala-newsletter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/frontend/pages/mutual-fund-classifications.blade.php ENDPATH**/ ?>