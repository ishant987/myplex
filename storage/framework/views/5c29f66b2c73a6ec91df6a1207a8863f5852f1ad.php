<?php $__env->startSection('breadcrumb'); ?>
<?php echo e(Breadcrumbs::render('aums.values.create')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
   <div class="col-sm-12">
      <div class="card m-b-0">
         <div class="card-header">
            <h5 class="card-header-text"><?php echo e(__('admin.fund.aums.upld_lbl_txt')); ?></h5>
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
            <form id="upload_bulk_sheet_form" name="upload_bulk_sheet_form" method="post" action="<?php echo e(route('admin.aums.values.store')); ?>" enctype="multipart/form-data">
               <?php echo e(csrf_field()); ?>

               <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt1_2_10','data' => ['label' => ''.e(__('admin.save_values_m_y_txt')).'','for' => 'entry_month','error' => ''.e($errors->first('entry_month')).'','required' => 'true']]); ?>
<?php $component->withName('form.group_lyt1_2_10'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('admin.save_values_m_y_txt')).'','for' => 'entry_month','error' => ''.e($errors->first('entry_month')).'','required' => 'true']); ?>
                  <div class="row">
                     <div class="col-sm-6">
                        <select id="entry_month" class="form-control" name="entry_month">
                           <option value=""><?php echo e(__('admin.month_def_opt_txt')); ?></option>
                           <?php if(!empty($otherData['months_list'])): ?>
                           <?php $__currentLoopData = $otherData['months_list']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $mValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <option value="<?php echo e($key); ?>" <?php echo e(( $key == old('entry_month') ) ? 'selected' : ''); ?>><?php echo e($mValue); ?></option>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           <?php endif; ?>
                        </select>
                     </div>
                     <div class="col-sm-6">
                        <select id="entry_year" class="form-control" name="entry_year">
                           <?php if(!empty($otherData['year_list'])): ?>
                           <?php $__currentLoopData = $otherData['year_list']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $yValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <option value="<?php echo e($yValue); ?>" <?php echo e(( $yValue == old('entry_year') ) ? 'selected' : ''); ?>><?php echo e($yValue); ?></option>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           <?php endif; ?>
                        </select>
                     </div>
                  </div>
                <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
               <div class="form-group has-primary row">
                  <label class="col-sm-2 col-form-label"><?php echo e(__('admin.last_save_txt')); ?></label>
                  <div class="col-sm-10">
                     <div class="col-form-label"><?php echo e($otherData['last_saved_date']); ?></div>
                  </div>
               </div>
               <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt1_2_10','data' => ['label' => ''.e(__('admin.file_txt')).'','for' => 'file_upload','error' => ''.e($errors->first('file_upload')).'','info' => ''.__('admin.fund.aums.file_format_info').'','required' => 'true']]); ?>
<?php $component->withName('form.group_lyt1_2_10'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('admin.file_txt')).'','for' => 'file_upload','error' => ''.e($errors->first('file_upload')).'','info' => ''.__('admin.fund.aums.file_format_info').'','required' => 'true']); ?>
                  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.file','data' => ['id' => 'file_upload','name' => 'file_upload']]); ?>
<?php $component->withName('form.field.file'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'file_upload','name' => 'file_upload']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
               <div class="row">
                  <div class="col-sm-12">
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt1_2_10','data' => ['class' => 'm-t-10']]); ?>
<?php $component->withName('form.group_lyt1_2_10'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'm-t-10']); ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.button','data' => ['id' => 'submit','name' => 'submit','text' => ''.e(__('admin.upload_txt')).'','value' => 'upload']]); ?>
<?php $component->withName('form.field.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'submit','name' => 'submit','text' => ''.e(__('admin.upload_txt')).'','value' => 'upload']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.button','data' => ['type' => 'reset','id' => 'cancel','name' => 'cancel','class' => 'btn-danger','text' => ''.e(__('admin.cancel_txt')).'']]); ?>
<?php $component->withName('form.field.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'reset','id' => 'cancel','name' => 'cancel','class' => 'btn-danger','text' => ''.e(__('admin.cancel_txt')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                      <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                  </div>
               </div>
            </form>
         </div>
         <!-- end of card-block -->
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/backend/pages/fund/aumsupload.blade.php ENDPATH**/ ?>