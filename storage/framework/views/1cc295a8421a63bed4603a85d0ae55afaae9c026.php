<?php $__env->startSection('dataTables'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('datetimePicker'); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<?php echo e(Breadcrumbs::render($editDataAtrArr['route'])); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5><?php echo e($editDataAtrArr['title']); ?></h5>
      </div>
      <div class="card-block">
        <!-- Show message. -->
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
        <form id="listDataForm" name="listDataForm" method="post" action="<?php echo e(route('admin.indices.values.update')); ?>">
          <?php echo e(csrf_field()); ?>

          
          <div class="row">
            <div class="col-sm-6">
              <!-- Database -->
              <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.button_def','data' => ['type' => 'submit','name' => 'submit','value' => 'save','text' => ''.e(__('admin.save_new_txt')).'','class' => 'btn btn-md btn-out-dashed waves-effect waves-light btn-primary btn-square','onclick' => 'return confirm(\''.e(__('message.confirm.save')).'\')?confirm(\''.e(__('message.confirm.click_ok_txt')).'\'):false']]); ?>
<?php $component->withName('form.field.button_def'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'submit','name' => 'submit','value' => 'save','text' => ''.e(__('admin.save_new_txt')).'','class' => 'btn btn-md btn-out-dashed waves-effect waves-light btn-primary btn-square','onclick' => 'return confirm(\''.e(__('message.confirm.save')).'\')?confirm(\''.e(__('message.confirm.click_ok_txt')).'\'):false']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
              <!-- Holiday -->
              <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.button_def','data' => ['type' => 'submit','name' => 'submit','value' => 'holiday','text' => ''.e(__('admin.save_holiday_txt')).'','class' => 'btn btn-md btn-out-dashed waves-effect waves-light btn-info btn-square','onclick' => 'return confirm(\''.e(__('message.confirm.holiday')).'\')?confirm(\''.e(__('message.confirm.click_ok_txt')).'\'):false']]); ?>
<?php $component->withName('form.field.button_def'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'submit','name' => 'submit','value' => 'holiday','text' => ''.e(__('admin.save_holiday_txt')).'','class' => 'btn btn-md btn-out-dashed waves-effect waves-light btn-info btn-square','onclick' => 'return confirm(\''.e(__('message.confirm.holiday')).'\')?confirm(\''.e(__('message.confirm.click_ok_txt')).'\'):false']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </div>
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-7">
                  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt1_7_5','data' => ['label' => ''.e(__('admin.save_values_date_txt')).'','for' => 'entry_date','error' => ''.e($errors->first('entry_date')).'','required' => 'true']]); ?>
<?php $component->withName('form.group_lyt1_7_5'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('admin.save_values_date_txt')).'','for' => 'entry_date','error' => ''.e($errors->first('entry_date')).'','required' => 'true']); ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'entry_date','name' => 'entry_date','value' => '','class' => 'def-date']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'entry_date','name' => 'entry_date','value' => '','class' => 'def-date']); ?>
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
                <div class="col-sm-5">
                  <div class="form-group has-primary row">
                    <label class="col-sm-6 col-form-label"><?php echo e(__('admin.last_save_txt')); ?></label>
                    <div class="col-sm-6">
                      <div class="col-form-label"><?php echo e($otherData['last_saved_date']); ?></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="table-responsive dt-responsive">
            <table id="dom-jqry-all" class="table table-striped table-bordered nowrap">
              <thead>
                <tr>
                  <th><?php echo e(__('admin.indices.name_txt')); ?></th>
                  <th><?php echo e(__('admin.indices.corelation_txt')); ?></th>
                  <th class="cc-w-95"><?php echo e(__('admin.indices.label_readonly_txt')); ?></th>
                  <th class="cc-w-95 no-sort"><?php echo e(__('admin.indices.value_txt')); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php if( count($dataListModel) > 0 ): ?>
                <?php $__currentLoopData = $dataListModel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr role="row" class="<?php echo e($record->closing_value == 'NA' || $record->closing_value == NULL?'no-record':''); ?>">
                  <td><?php echo e($record->name); ?></td>
                  <td><?php echo e($record->corelation); ?></td>
                  <td><?php echo e($record->closing_value != '' ? $record->closing_value : 'NA'); ?></td>
                  <td>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'c_value_'.e($loop->iteration).'','name' => 'c_value['.e($record->corelation).']','value' => ''.e($record->closing_value != '' ? $record->closing_value : 'NA').'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'c_value_'.e($loop->iteration).'','name' => 'c_value['.e($record->corelation).']','value' => ''.e($record->closing_value != '' ? $record->closing_value : 'NA').'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                  </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                <tr>
                  <td colspan="4"><?php echo e(__('message.data_not_available')); ?></td>
                </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
  $(function() {
    $("#entry_date[value='']").datepicker("setDate", "0d");
  });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/backend/pages/indices/idcuploadedlist.blade.php ENDPATH**/ ?>