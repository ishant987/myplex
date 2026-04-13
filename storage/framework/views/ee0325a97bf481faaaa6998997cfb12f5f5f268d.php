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
                            .login-banner {
                                background-image: url('<?php echo e($dataArr['image_path']); ?>');
                            }

                        </style>
                    <?php $__env->stopPush(); ?>
                <?php endif; ?>
                <?php if($dataArr['full_url']): ?>
                    <?php $__env->startSection('cur-url'); ?><?php echo e($dataArr['full_url']); ?><?php $__env->stopSection(); ?>
                    <?php endif; ?>
                    <?php $__env->startSection('content'); ?>
                        <div class="custom-banner no-bg login-banner">
                            <div class="container">
                                <h1 class="f-b"><?php echo e($dataArr['title']); ?></h1>
                                <?php if($dataArr['descp'] != ''): ?>
                                    <h3 class="f-sb text-green"><?php echo $dataArr['descp']; ?></h3>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/themes/frontend/pages/404.blade.php ENDPATH**/ ?>