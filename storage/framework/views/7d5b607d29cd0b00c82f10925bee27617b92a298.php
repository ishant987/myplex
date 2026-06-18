<?php $__env->startSection('dataTables'); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<?php echo e(Breadcrumbs::render('fundtaxation.index')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5><?php echo e(__('admin.fundtaxation.all_txt')); ?></h5>
        <?php if($roleRights['add']): ?>
        <!-- Add New -->
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_add_new','data' => ['url' => ''.e(route('admin.fund-taxation.create')).'']]); ?>
<?php $component->withName('link_add_new'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.fund-taxation.create')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        <?php endif; ?>
        <?php if($roleRights['delete']): ?>
        <?php if( count( $dataListModel ) > 0 ): ?>
        <!-- Multi Delete -->
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.btn_multi_delete','data' => []]); ?>
<?php $component->withName('form.btn_multi_delete'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        &nbsp;
        <?php endif; ?>
        <?php endif; ?>
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
        <form id="listDataForm" name="listDataForm" method="post" action="<?php echo e(route('admin.fund-taxation.delete')); ?>">
          <?php echo e(csrf_field()); ?>

          <div class="table-responsive dt-responsive">
            <table id="dom-jqry" class="table table-striped table-bordered nowrap">
              <thead>
                <tr>
                  <?php if($roleRights['delete']): ?>
                  <?php if( count( $dataListModel ) > 0 ): ?>
                  <th class="cc-w-35 no-sort-del">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.checkbox','data' => ['style' => 'default','name' => 'check_all','id' => 'check_all']]); ?>
<?php $component->withName('form.field.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['style' => 'default','name' => 'check_all','id' => 'check_all']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                  </th>
                  <?php endif; ?>
                  <?php endif; ?>
                  <th><?php echo e(__('admin.title_txt')); ?></th>
                  <th class="cc-w-70 no-sort"><?php echo e(__('admin.file_txt')); ?></th>
                  <?php if( $fldsHide['c_order'] == $boolFalse ): ?>
                  <th class="cc-w-60"><?php echo e(__('admin.order_txt')); ?></th>
                  <?php endif; ?>
                  <th class="cc-w-60 no-sort"><?php echo e(__('admin.status_txt')); ?></th>
                  <th class="cc-w-150"><?php echo e(__('admin.mdfy_date_txt')); ?></th>
                  <th class="cc-w-95 no-sort"><?php echo e(__('admin.mdfy_by_txt')); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php if( count($dataListModel) > 0 ): ?>
                <?php $__currentLoopData = $dataListModel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr role="row" class="">
                  <?php if($roleRights['delete']): ?>
                  <td class="sorting_<?php echo e($record->ft_id); ?>">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.checkbox','data' => ['style' => 'default','name' => 'checkbox[]','value' => ''.e($record->ft_id).'','fldclass' => 'del-chkbx']]); ?>
<?php $component->withName('form.field.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['style' => 'default','name' => 'checkbox[]','value' => ''.e($record->ft_id).'','fldclass' => 'del-chkbx']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                  </td>
                  <?php endif; ?>
                  <td>
                    <?php if($roleRights['edit']): ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_tooltip','data' => ['url' => ''.e(route('admin.fund-taxation.edit', $record->ft_id)).'','title' => ''.e($listDataAtrArr['edit_txt']).'']]); ?>
<?php $component->withName('link_tooltip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.fund-taxation.edit', $record->ft_id)).'','title' => ''.e($listDataAtrArr['edit_txt']).'']); ?>
                      <?php echo e($record->title); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php else: ?>
                    <?php echo e($record->title); ?>

                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if( $record->file != '' ): ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_tooltip','data' => ['url' => ''.e($moduleAtrArr['media_folder'].$record->file).'','title' => ''.e($moduleAtrArr['view_txt']).'','target' => ''.e($moduleAtrArr['target']).'','class' => 'f-30 m-b-10','placement' => 'right']]); ?>
<?php $component->withName('link_tooltip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e($moduleAtrArr['media_folder'].$record->file).'','title' => ''.e($moduleAtrArr['view_txt']).'','target' => ''.e($moduleAtrArr['target']).'','class' => 'f-30 m-b-10','placement' => 'right']); ?>
                      <i class="fa fa-file-pdf-o"></i>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php endif; ?>
                  </td>
                  <?php if( $fldsHide['c_order'] == $boolFalse ): ?>
                  <td><?php echo e($record->c_order > 0 ? $record->c_order : ''); ?></td>
                  <?php endif; ?>
                  <td>
                    <?php if($roleRights['edit']): ?>
                    <label id="change_status<?php echo e($record->ft_id); ?>" onclick="return changeStatus('ft_id', <?php echo e($record->ft_id); ?>, 'fund_taxation', <?php echo e($record->status); ?>, '<?php echo e($statusAtrArr['status_type']); ?>');" class="label btn-<?php echo e($listDataAtrArr['alert_css'][$record->status]); ?>"><?php echo e($statusAtrArr['label'][$record->status]); ?></label>
                    <?php else: ?>
                    <label class="label btn-<?php echo e($listDataAtrArr['alert_css'][$record->status]); ?> no-drop"><?php echo e($statusAtrArr['label'][$record->status]); ?></label>
                    <?php endif; ?>
                  </td>
                  <td><?php echo e(date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->updated_at))); ?></td>
                  <td><?php echo e($record->updatedby->display_name ?? $listDataAtrArr['unknown_txt']); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                <tr>
                  <td colspan="7"><?php echo e(__('message.data_not_available')); ?></td>
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
<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/backend/pages/fundtaxation/index.blade.php ENDPATH**/ ?>