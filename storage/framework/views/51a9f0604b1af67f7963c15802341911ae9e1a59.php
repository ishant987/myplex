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


<!-- <div class="custom-banner no-bg cms-page">
    <div class="container">
        <h1 class="f-b"><?php echo e($dataArr['title']); ?></h1>
    </div>
</div>   -->

<div id="vue-app" data-v-app="">

    <div class="custom-banner no-bg fw-bannerfund-portfolio-banner monthly-ranking monthly-snapshot-banner">
        <section class="inner_banner_section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="inner_section_banner">
                        <h4 class="f-b"><?php echo e($dataArr['title']); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="blog-wrapper cms-page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 cms-page-block">
                    <?php echo $dataArr['descp']; ?>

                </div>
            </div>
        </div>
    </div> 

</div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/themes/frontend/pages/page.blade.php ENDPATH**/ ?>