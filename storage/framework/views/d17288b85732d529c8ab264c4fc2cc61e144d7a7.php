<?php $__env->startSection('dataTables'); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<?php echo e(Breadcrumbs::render($editDataAtrArr['route'], $dataArr)); ?> 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card m-b-0">
            <div class="card-header">
                <h5 class="card-header-text"><?php echo e($editDataAtrArr['title']); ?></h5>
                <!-- Edit New -->
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_edit_new','data' => ['title' => 'Edit','url' => ''.e(route('admin.customfield.edit', $dataArr->cf_group_id)).'']]); ?>
<?php $component->withName('link_edit_new'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['title' => 'Edit','url' => ''.e(route('admin.customfield.edit', $dataArr->cf_group_id)).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </div>
            <div class="card-block">

            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt1_2_10','data' => ['label' => ''.e(__('admin.title_txt')).'','for' => 'title','error' => ''.e($errors->first('title')).'']]); ?>
<?php $component->withName('form.group_lyt1_2_10'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('admin.title_txt')).'','for' => 'title','error' => ''.e($errors->first('title')).'']); ?>
                <i><?php echo e($dataArr->title); ?></i>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.group_lyt1_2_10','data' => ['label' => ''.e(__('admin.status_txt')).'','for' => 'status','error' => ''.e($errors->first('status')).'']]); ?>
<?php $component->withName('form.group_lyt1_2_10'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => ''.e(__('admin.status_txt')).'','for' => 'status','error' => ''.e($errors->first('status')).'']); ?>
                <i><?php echo e($moduleAtrArr['status']); ?></i>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            
            </div>
            <!-- end of card-block -->
        </div>
    </div>
</div>

<!-- Custom fields groups -->

<div class="row">
    <div class="col-sm-12">
        <div class="card m-b-0">
            <div class="card-header">
                <h5 class="card-header-text"><?php echo e($editDataAtrArr['titlegt']); ?></h5>
                <!-- Add New -->
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_add_new','data' => ['url' => ''.e(route('admin.customfield.grouptype.create', $dataArr->cf_group_id)).'']]); ?>
<?php $component->withName('link_add_new'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.customfield.grouptype.create', $dataArr->cf_group_id)).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                
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
                <form id="listDataForm" name="listDataForm" method="post" action="<?php echo e(route('admin.deletecustomfieldgrouptype')); ?>">
                    <?php echo e(csrf_field()); ?>

                    <div class="table-responsive dt-responsive">
                        <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
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
                                <th><?php echo e(__('admin.customfield.field_name_txt')); ?></th>
                                <th><?php echo e(__('admin.customfield.field_type_txt')); ?></th>
                                <th><?php echo e(__('admin.customfield.field_for_txt')); ?></th>
                                <th><?php echo e(__('admin.customfield.field_options_txt')); ?></th>
                                <th class="cc-w-60"><?php echo e(__('admin.order_txt')); ?></th>
                                <th class="cc-w-60 no-sort"><?php echo e(__('admin.status_txt')); ?></th>
                                <th class="cc-w-150"><?php echo e(__('admin.mdfy_date_txt')); ?></th>
                                <th class="cc-w-95 no-sort"><?php echo e(__('admin.mdfy_by_txt')); ?></th>
                                <th class="cc-w-95 no-sort"><?php echo e(__('admin.action_txt')); ?></th>
                                </tr>
                            </thead>
                            <tbody>      
                                <?php if( count($dataListModel) > 0 ): ?>       
                                <?php $__currentLoopData = $dataListModel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr role="row" class="">
                                <td class="sorting_<?php echo e($record->cf_group_type_id); ?>">
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.checkbox','data' => ['style' => 'default','name' => 'checkbox[]','value' => ''.e($record->cf_group_type_id).'','fldclass' => 'del-chkbx']]); ?>
<?php $component->withName('form.field.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['style' => 'default','name' => 'checkbox[]','value' => ''.e($record->cf_group_type_id).'','fldclass' => 'del-chkbx']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </td>
                                <td>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_tooltip','data' => ['url' => ''.e(route('admin.customfield.grouptype.edit', [ $record->cf_group_id, $record->cf_group_type_id])).'','title' => '']]); ?>
<?php $component->withName('link_tooltip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.customfield.grouptype.edit', [ $record->cf_group_id, $record->cf_group_type_id])).'','title' => '']); ?>
                                <?php echo e($record->field_name); ?>

                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </td>
                                <td><?php echo e($record->field_type); ?></td>
                                <td><?php echo e($record->getCfForAssoc()[$record->field_for]); ?></td>
                                <td>
                                    <?php echo __('admin.customfield.grouptype.label_txt').': <i>'.$record->field_options['label'].'</i>'; ?><br/>
                                    <?php echo __('admin.customfield.grouptype.placeholder_txt').': <i>'.$record->field_options['placeholder'].'</i>'; ?><br/>
                                    <?php echo e(__('admin.customfield.grouptype.required_txt')); ?>: <?php echo '<i>'.$record->field_options['required']?'Yes':'No'.'</i>'; ?><br/>
                                    <?php echo __('admin.customfield.grouptype.description_txt').': <i>'.$record->field_options['description'].'</i>'; ?><br/>
                                    <?php echo __('admin.customfield.grouptype.instruction_txt').': <i>'.$record->field_options['instruction'].'</i>'; ?>

                                </td>
                                <td><?php echo e($record->c_order); ?></td>
                                <td>
                                <label id="change_status<?php echo e($record->cf_group_type_id); ?>" onclick="return changeStatus('cf_group_type_id', <?php echo e($record->cf_group_type_id); ?>, 'custom_field_group_type', <?php echo e($record->status); ?>, '<?php echo e($statusAtrArr['status_type']); ?>','<?php echo e(route('admin.changestatus')); ?>');" class="label btn-<?php echo e($listDataAtrArr['alert_css'][$record->status]); ?>"><?php echo e($statusAtrArr['label'][$record->status]); ?></label>                                   
                                </td>
                                <td><?php echo e(strtotime($record->updated_at)?date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->updated_at)):''); ?></td>
                                <td><?php echo e($record->updatedby->display_name ?? $listDataAtrArr['unknown_txt']); ?></td>
                                <td>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_tooltip','data' => ['url' => ''.e(route('admin.customfield.grouptype.show', [$record->cf_group_id, $record->cf_group_type_id])).'','title' => 'List','class' => 'f-20','placement' => 'left']]); ?>
<?php $component->withName('link_tooltip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.customfield.grouptype.show', [$record->cf_group_id, $record->cf_group_type_id])).'','title' => 'List','class' => 'f-20','placement' => 'left']); ?>
                                        <i class="ti-view-list"></i>
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
<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/backend/pages/customfield/show.blade.php ENDPATH**/ ?>