<?php $__env->startPush('styles'); ?> 
<link href="<?php echo e(asset('themes/backend/files/assets/pages/jquery.filer/css/jquery.filer.css')); ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo e(asset('themes/backend/files/assets/pages/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css')); ?>" type="text/css" rel="stylesheet" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<?php echo e(Breadcrumbs::render('media.create')); ?> 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
   <div class="col-sm-12">
      <div class="card m-b-0">
         <div class="card-header">
            <h5 class="card-header-text"><?php echo e(__('media.add_txt')); ?></h5>
         </div>
         <div class="card-block">
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.alert','data' => ['type' => ''.e(session()->get('alert')).'','title' => ''.e(session()->get('title')).'','message' => ''.e(session()->get('message')).'']]); ?>
<?php $component->withName('form.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => ''.e(session()->get('alert')).'','title' => ''.e(session()->get('title')).'','message' => ''.e(session()->get('message')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <form name="mdaForm" id="mdaForm" action="<?php echo e(route('admin.media.ajaxupload')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>

               <input type="file" name="files[]"  id="filer_input1" multiple="multiple">
               <div class="col-form-label info">
                  <ul>
                     <li><i class="fa fa-info"></i> Upload only JPG / JPEG, PNG, GIF, SVG, PDF, DOC, XLS and PPT files.</li>
                     <li><i class="fa fa-info"></i> Only 10 files are allowed to be uploaded at a time.</li>
                     <li><i class="fa fa-info"></i> Max File uploads limit 30 MB.</li>
                  </ul>
               </div>
            </form>           
         </div>
         <!-- end of card-block -->
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?> 
<!-- jquery file upload js -->
<script src="<?php echo e(asset('themes/backend/files/assets/pages/jquery.filer/js/jquery.filer.min.js')); ?>"></script>
<script src="<?php echo e(asset('themes/backend/files/assets/pages/filer/jquery.fileuploads.init.js')); ?>"></script>
<script>
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/backend/pages/media/createform.blade.php ENDPATH**/ ?>