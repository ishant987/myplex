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
<link rel="stylesheet" href="<?php echo e(asset('themes/frontend/assets/jquery-bar-rating-master/dist/themes/fontawesome-stars.css')); ?>">
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
<div class="custom-banner no-bg pent-banner">
    <div class="container">
        <?php if(isset($dataArr['custom_fields']['textarea_29'])): ?>
        <h1 class="f-b"><?php echo nl2br($dataArr['custom_fields']['textarea_29']['value']); ?></h1>
        <?php endif; ?>
    </div>
</div>

<div class="pent-filter">
    <div class="container">
        <h3 class="text-center"><?php echo e($dataArr['title']); ?></h3>
        <div class="pent-filter-wrap">
            <?php if(isset($dataArr['custom_fields']['editor_70'])): ?>
            <?php echo $dataArr['custom_fields']['editor_70']['value']; ?>

            <?php endif; ?>
        </div>
    </div>
</div>

<div class="pent-content-block bg-gry">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-12 pent-cnt-lft">
                <?php if(isset($dataArr['custom_fields']['textarea_69'])): ?>
                <span><?php echo nl2br($dataArr['custom_fields']['textarea_69']['value']); ?></span>
                <?php endif; ?>
            </div>
            <div class="col-sm-12 pent-cnt-rgt">
                <?php echo $dataArr['descp']; ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/themes/frontend/pages/pentatec-filter.blade.php ENDPATH**/ ?>