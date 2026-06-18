<?php $__env->startSection('dataTables'); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<?php echo e(Breadcrumbs::render('topic.index')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5><?php echo e(__('askexpert.topic.all_txt')); ?></h5>
        <?php if($roleRights['add']): ?>
        <!-- Add New -->
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_add_new','data' => ['url' => ''.e(route('admin.topic.create')).'']]); ?>
<?php $component->withName('link_add_new'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.topic.create')).'']); ?>
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
        <form id="listDataForm" name="listDataForm" method="post" action="<?php echo e(route('admin.topic.delete')); ?>">
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
                  <?php if( $fldsHide['image'] == $boolFalse ): ?>
                  <th class="cc-w-70 no-sort"><?php echo e(__('admin.image_txt')); ?></th>
                  <?php endif; ?>
                  <th><?php echo e(__('admin.parent_txt')); ?></th>
                  <?php if( $fldsHide['c_order'] == $boolFalse ): ?>
                  <th class="cc-w-60"><?php echo e(__('admin.order_txt')); ?></th>
                  <?php endif; ?>
                  <th class="cc-w-60 no-sort"><?php echo e(__('admin.status_txt')); ?></th>
                  <th class="cc-w-150"><?php echo e(__('admin.added_date_txt')); ?></th>
                  <th class="cc-w-60"><?php echo e(__('admin.created_medium_txt')); ?></th>
                  <th class="cc-w-60"><?php echo e(__('admin.added_by_txt')); ?></th>
                  <th class="cc-w-150"><?php echo e(__('admin.added_user_txt')); ?></th>
                  <th class="cc-w-150"><?php echo e(__('admin.mdfy_date_txt')); ?></th>
                  <th class="cc-w-95 no-sort"><?php echo e(__('admin.mdfy_by_txt')); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php if( count($dataListModel) > 0 ): ?>
                <?php $__currentLoopData = $dataListModel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr role="row" class="">
                  <?php if($roleRights['delete']): ?>
                  <td class="sorting_<?php echo e($record->aet_id); ?>">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.checkbox','data' => ['style' => 'default','name' => 'checkbox[]','value' => ''.e($record->aet_id).'','fldclass' => 'del-chkbx']]); ?>
<?php $component->withName('form.field.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['style' => 'default','name' => 'checkbox[]','value' => ''.e($record->aet_id).'','fldclass' => 'del-chkbx']); ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_tooltip','data' => ['url' => ''.e(route('admin.topic.edit', $record->aet_id)).'','title' => ''.e($listDataAtrArr['edit_txt']).'']]); ?>
<?php $component->withName('link_tooltip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.topic.edit', $record->aet_id)).'','title' => ''.e($listDataAtrArr['edit_txt']).'']); ?>
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
                  <?php if( $fldsHide['image'] == $boolFalse ): ?>
                  <td>
                    <?php if( $record->media != null ): ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_tooltip','data' => ['url' => ''.e($record->media->getModuleVars()['media_folder'].$record->media['path']).'','title' => ''.e($record->media->getModuleVars()['view_txt']).'','target' => ''.e($record->media->getModuleVars()['target']).'','placement' => 'right']]); ?>
<?php $component->withName('link_tooltip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e($record->media->getModuleVars()['media_folder'].$record->media['path']).'','title' => ''.e($record->media->getModuleVars()['view_txt']).'','target' => ''.e($record->media->getModuleVars()['target']).'','placement' => 'right']); ?>
                      <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e($record->media->getModuleVars()['media_folder'].$record->media['path']).'','width' => ''.e($record->media->getModuleVars()['img_width']['small']).'','class' => 'img-fluid img-thumbnail w-70']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e($record->media->getModuleVars()['media_folder'].$record->media['path']).'','width' => ''.e($record->media->getModuleVars()['img_width']['small']).'','class' => 'img-fluid img-thumbnail w-70']); ?>
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
                    <?php endif; ?>
                  </td>
                  <?php endif; ?>
                  <td><?php echo e($record->parentdata != null ? $record->parentdata->title : ''); ?></td>
                  <?php if( $fldsHide['c_order'] == $boolFalse ): ?>
                  <td><?php echo e($record->c_order > 0 ? $record->c_order : ''); ?></td>
                  <?php endif; ?>
                  <td>
                    <?php if($roleRights['edit']): ?>
                    <label id="change_status<?php echo e($record->aet_id); ?>" onclick="return changeStatus('aet_id', <?php echo e($record->aet_id); ?>, 'ask_expert_topic', <?php echo e($record->status); ?>, '<?php echo e($statusAtrArr['status_type']); ?>');" class="label btn-<?php echo e($listDataAtrArr['alert_css'][$record->status]); ?>"><?php echo e($statusAtrArr['label'][$record->status]); ?></label>
                    <?php else: ?>
                    <label class="label btn-<?php echo e($listDataAtrArr['alert_css'][$record->status]); ?> no-drop"><?php echo e($statusAtrArr['label'][$record->status]); ?></label>
                    <?php endif; ?>
                  </td>
                  <td><?php echo e(date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->created_at))); ?></td>
                  <td><?php echo e($record->medium()); ?></td>
                  <td><?php echo e($moduleAtrArr['cu_by_txt'][$record->created_by] ?? $listDataAtrArr['unknown_txt']); ?></td>
                  <td>
                    <?php switch($record->created_by):
                    case ($moduleAtrArr['cu_by_val'][1]): ?>
                    <?php echo e($record->addedby->display_name ?? $listDataAtrArr['unknown_txt']); ?>

                    <?php break; ?>
                    <?php case ($moduleAtrArr['cu_by_val'][2]): ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_tooltip','data' => ['url' => ''.e(route('admin.subscribeduser.edit', $record->addedbyuser->u_id)).'','title' => ''.e($moduleAtrArr['view_txt']).'','target' => ''.e($moduleAtrArr['target']).'']]); ?>
<?php $component->withName('link_tooltip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.subscribeduser.edit', $record->addedbyuser->u_id)).'','title' => ''.e($moduleAtrArr['view_txt']).'','target' => ''.e($moduleAtrArr['target']).'']); ?>
                      <?php echo e($record->addedbyuser->f_name.' '.$record->addedbyuser->l_name ?? $listDataAtrArr['unknown_txt']); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php break; ?>
                    <?php endswitch; ?>
                  </td>
                  <td><?php if($record->updated_at != ''): ?><?php echo e(date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->updated_at))); ?><?php endif; ?></td>
                  <td><?php if($record->updated_id > 0): ?><?php echo e($record->updatedbyadmin->display_name ?? $listDataAtrArr['unknown_txt']); ?><?php endif; ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                <tr>
                  <td colspan="9"><?php echo e(__('message.data_not_available')); ?></td>
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
<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/backend/pages/topic/index.blade.php ENDPATH**/ ?>