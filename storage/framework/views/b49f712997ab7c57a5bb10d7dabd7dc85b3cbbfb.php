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
<div class="custom-banner no-bg know-ratios-banner">
    <div class="container">
        <?php if(isset($dataArr['custom_fields']['textarea_29'])): ?>
        <h1 class="f-b"><?php echo nl2br($dataArr['custom_fields']['textarea_29']['value']); ?></h1>
        <?php endif; ?>
    </div>
</div>

<div class="faq-main know-ratio-wrap">
    <div class="container">
        <h3><?php echo e($dataArr['title']); ?></h3>
        <div class="faq-wrap">
            <?php if(count($dataArr['know_the_ratio']) == 0): ?>
            <p><?php echo e(__('message.data_not_available')); ?></p>
            <?php else: ?>
            <div id="accordion">
                <?php $__currentLoopData = $dataArr['know_the_ratio']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card">
                    <div class="card-header" id="heading_<?php echo e($record->ktr_id); ?>">
                        <h5 class="mb-0">
                            <button class="btn btn-link<?php echo e(($index == 0)?'':' collapsed'); ?>" data-toggle="collapse" data-target="#collapse_<?php echo e($record->ktr_id); ?>" aria-expanded="<?php echo e(($index == 0)?'true':'false'); ?>" aria-controls="collapse_<?php echo e($record->ktr_id); ?>"><?php echo e($record->title); ?></button>
                        </h5>
                    </div>
                    <div id="collapse_<?php echo e($record->ktr_id); ?>" class="collapse<?php echo e(($index == 0)?' show':''); ?>" aria-labelledby="heading_<?php echo e($record->ktr_id); ?>" data-parent="#accordion">
                        <div class="card-body">
                            <?php if( $record->media != null ): ?>
                            <div class="row align-items-center">
                                <div class="col-lg-6 col-md-6 col-sm-12 know-ration-para">
                                    <?php echo $record->description; ?>

                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 know-ration-img">
                                    <?php if( $record->media['path'] ): ?>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e($defDataArr['media_folder'].$record->media->path).'','alt' => ''.e($record->media->alt).'','title' => ''.e($record->media->title).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e($defDataArr['media_folder'].$record->media->path).'','alt' => ''.e($record->media->alt).'','title' => ''.e($record->media->title).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php else: ?>
                            <?php echo $record->description; ?>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php echo $__env->make('themes.frontend.includes.patshala-newsletter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/frontend/pages/know-the-ratio.blade.php ENDPATH**/ ?>