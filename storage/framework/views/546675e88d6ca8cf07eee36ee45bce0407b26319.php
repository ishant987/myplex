<?php $__env->startSection('select2'); ?> <?php $__env->stopSection(); ?>
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

<div class="mutual-f-taxation bg-gry">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-5 col-md-5 col-sm-12 mutual-f-tax-rgt">
                <h3><?php echo e($fundTxnMdl->title); ?></h3>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12 mutual-f-tax-lft">
                <?php if(count($fundTxnListMdl) > 0): ?>
                <div class="row">
                    <div class="col-lg-7 col-md-7 col-sm-12 select2-styles mutual-f-tax-in-lft">
                        <select id="mutual_fund_taxation" class="js-example-placeholder-single js-states form-control" onchange="window.location='<?php echo e(url('/mutual-fund-taxation/')); ?>/' + this.value;">
                            <?php $__currentLoopData = $fundTxnListMdl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($record->ft_id); ?>" <?php echo e(($record->ft_id == $fundTxnMdl->ft_id)?'selected=selected':''); ?>><?php echo e($record->title); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php if($fundTxnMdl->file): ?>
<div class="mutual-fund-pdf-wrap">
    <div class="container">
        <div class="inner-pdf-wrap br-5 border-s box-shadow">
            <embed src="<?php echo e($defDataArr['media_folder'].$fundTxnMdl->file); ?>" type="application/pdf" width="100%" height="500px">
        </div>
    </div>
</div>
<?php endif; ?>
<?php echo $__env->make('themes.frontend.includes.patshala-newsletter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
    $('#mutual_fund_taxation').select2({
        placeholder: "Recent Archives"
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('themes.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/frontend/pages/mutual-fund-taxation.blade.php ENDPATH**/ ?>