<?php $__env->startSection('breadcrumb'); ?>
<?php echo e(Breadcrumbs::render('contact.show', $id)); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5><?php echo e(__('contact.show_txt')); ?></h5>
      </div>
      <div class="card-block">

        <div class="row">
          <div class="col-sm-12">
            <?php if( $dataObj ): ?>
            <div class="form-group has-primary row">
              <label class="col-3 col-form-label"><?php echo e(__('contact.name_txt')); ?></label>
              <div class="col-9">
                <div class="col-form-label"><?php echo e($dataObj[0]->name); ?></div>
              </div>
            </div>
            <div class="form-group has-primary row">
              <label class="col-3 col-form-label"><?php echo e(__('contact.email_txt')); ?></label>
              <div class="col-9">
                <div class="col-form-label"><?php echo e($dataObj[0]->email); ?></div>
              </div>
            </div>
            <div class="form-group has-primary row">
              <label class="col-3 col-form-label"><?php echo e(__('contact.mobile_txt')); ?></label>
              <div class="col-9">
                <div class="col-form-label"><?php echo e($dataObj[0]->mobile); ?></div>
              </div>
            </div>
            <div class="form-group has-primary row">
              <label class="col-3 col-form-label"><?php echo e(__('contact.message_txt')); ?></label>
              <div class="col-9">
                <div class="col-form-label"><?php echo $dataObj[0]->message; ?></div>
              </div>
            </div>
            <div class="form-group has-primary row">
              <label class="col-3 col-form-label"><?php echo e(__('admin.added_date_txt')); ?></label>
              <div class="col-9">
                <div class="col-form-label"><?php echo e(date($listDataAtrArr['mdfy_dt_frmt'], strtotime($dataObj[0]->created_at))); ?></div>
              </div>
            </div>
            <?php endif; ?>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/backend/pages/contact/show.blade.php ENDPATH**/ ?>