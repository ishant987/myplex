<?php $__env->startSection('breadcrumb'); ?>
<?php echo e(Breadcrumbs::render('dashboard',$errorCode)); ?> 
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5><?php echo e($heading ? $heading:  'Not Found'); ?>  !</h5>
        <span><?php echo $message; ?></span>
    </div>
    <div class="card-block">
        <div class="row">
            <div class="col-sm-12 m-b-30">
                
        <?php if($errors->any()): ?>
        <h4><?php echo e($errors->first()); ?></h4>
        <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/backend/pages/default/error.blade.php ENDPATH**/ ?>