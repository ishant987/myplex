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
<div class="custom-banner no-bg fund-watch-landing-page">
    <div class="container">
        <h1 class="f-b"><?php echo e($dataArr['title']); ?></h1>
    </div>
</div>

<div class="blog-wrapper fund-watch-listing fw-single-page">
    <div class="container">
        <div class="blog-inner-wrapper">
            <div class="row">
                <div class="col-lg-9 col-md-12 col-sm-12 fw-single-block">
                    <h3><?php echo e($dataArr['item']->title); ?></h3>
                    <div class="fw-single-content">
                        <?php if($dataArr['item']->description): ?>
                        <p><?php echo nl2br($dataArr['item']->description); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="fw-pdf-donwload">
                        <?php if($dataArr['item']->file): ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e($defDataArr['media_folder'].$dataArr['item']->file).'','target' => '_blank']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e($defDataArr['media_folder'].$dataArr['item']->file).'','target' => '_blank']); ?>Download PDF <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <div class="fw-single-file">
                        <?php if($dataArr['item']->file): ?>
                        <?php echo e($defDataArr['media_folder'].$dataArr['item']->file); ?>

                        <embed src="<?php echo e($defDataArr['media_folder'].$dataArr['item']->file); ?>" width="100%" height="375" type="application/pdf">
                        <?php endif; ?>
                    </div>
                </div>
                <?php echo $__env->make('themes.frontend.includes.fund-watch-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/frontend/pages/fund-watch.blade.php ENDPATH**/ ?>