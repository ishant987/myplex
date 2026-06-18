<?php $__env->startSection('breadcrumb'); ?>
<?php echo e(Breadcrumbs::render('adminrole.create')); ?> 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
   <div class="col-sm-12">
      <div class="card m-b-0">
         <div class="card-header">
            <h5 class="card-header-text"><?php echo e(__('admin.add_admnrole_user_txt')); ?></h5>
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
            
            <form name="aeUsrFrm" id="aeUsrFrm" action="<?php echo e(route('admin.adminrole.store')); ?>" method="POST">
              <?php echo e(csrf_field()); ?>


              <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt1_2_10','data' => ['label' => ''.e(__('admin.rolename_txt')).'','for' => 'title','error' => ''.e($errors->first('title')).'','required' => 'true']]); ?>
<?php $component->withName('form.group_lyt1_2_10'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('admin.rolename_txt')).'','for' => 'title','error' => ''.e($errors->first('title')).'','required' => 'true']); ?>
                  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'title','name' => 'title','value' => ''.e(old('title')).'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'title','name' => 'title','value' => ''.e(old('title')).'']); ?>
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

              <div class="form-group row">
               <label class="col-sm-2 col-form-label">Modules Access<span class="required">*</span></label>
               <div class="col-sm-10">
                 <div class="table-responsive dt-responsive">
                    <table class="table table-bordered m-b-0 user-role-table">
                       <thead>
                          <tr>
                             <td>Module</td>
                             <td colspan=5>
                                <div class="checkbox-fade has-primary fade-in-default pull-left" style="margin-right: 10px">
                                <label>
                                  <input type="checkbox" id="checkAll">
                                <span class="cr dcr" >
                                  <i class="cr-icon icofont icofont-ui-check txt-default"></i>
                                </span>
                                <span class="text-inverse m-l-5 cell-breakWord">
                                Check All Pages
                                </span>
                                </label></div>
                             </td>
                          </tr>
                       </thead>
                       <tbody>
                        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
                          <?php if($module->getModuleMethods() && count($module->getModuleMethods())>0): ?>
                           <tr class="<?php echo e($maxTdCnt); ?>">
                              <td>
                                <div class="checkbox-fade has-primary fade-in-default <?php if($module->parent_module_id==0): ?> is_parent <?php endif; ?>">
                                   <label>
                                   <span class="text-inverse m-l-5 font-12"><strong><?php echo e($module->title); ?></strong></span>
                                   </label>
                                </div>
                             </td>
                              <?php $__currentLoopData = $module->getModuleMethods(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2=>$method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <td <?php if( $maxTdCnt !=count($module->getModuleMethods()) && $key2==count($module->getModuleMethods())-1 ): ?> colspan="<?php echo e($maxTdCnt-$key2); ?>" <?php endif; ?> class="user-method-perm ">
                                <input type="hidden" name="hid_method_id" value="<?php echo e($method->method_id); ?>">
                                <div class="checkbox-fade has-primary fade-in-default">
                                   <label>
                                    <?php if($method->default_present == 0): ?>
                                      <input type="checkbox" name="method[]" value="<?php echo e($method->method_id); ?>">
                                      <span class="cr">
                                      <i class="cr-icon icofont icofont-ui-check txt-default"></i>
                                     </span>
                                    <?php else: ?>
                                    <input type="checkbox" name="method[]" value="<?php echo e($method->method_id); ?>" checked="checked" disabled="disabled">
                                    <input type="hidden" name="method[]" value="<?php echo e($method->method_id); ?>">
                                      <span class="cr dcr"  title="Disabled as it must present to all users">
                                      <i class="cr-icon icofont icofont-ui-check txt-default"></i>
                                     </span>
                                    <?php endif; ?>
                                   
                                   <span class="text-inverse m-l-5 cell-breakWord">
                                    <?php if($method->is_left_nav>0): ?>
                                    <i class="fa fa-plus m-r-5 text-c-red"></i>
                                    <?php endif; ?>
                                    <?php echo e($method->title); ?>

                                    </span>
                                   </label>
                                </div>
                              </td>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                             <?php endif; ?>
                           </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                       </tbody>
                    </table>
                 </div>
                    <div class="info">
                      <strong> NOTE:</strong>
                      <div class="is_parent"><span class="text-inverse italic">Parent module(colored red) & page with [<i class="fa fa-plus text-c-red"></i>] must ticked (if sub-module is ticked) to appear in left menu</span></div>
                    </div>
               </div>
            </div>

               <div class="row">
                  <div class="col-sm-12">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt1_2_10','data' => ['class' => 'm-t-10']]); ?>
<?php $component->withName('form.group_lyt1_2_10'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'm-t-10']); ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.button','data' => ['id' => 'submit','name' => 'submit']]); ?>
<?php $component->withName('form.field.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'submit','name' => 'submit']); ?>
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
<?php $__env->startPush('scripts'); ?> 
<script>
  $("#checkAll").click(function () {
     $('input:checkbox').not(this).prop('checked', this.checked);
 });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/backend/pages/adminrole/createform.blade.php ENDPATH**/ ?>