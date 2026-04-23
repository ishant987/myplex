<?php $__env->startSection('datetimeRangePicker'); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php echo e(Breadcrumbs::render('answer.index', $fltrDataArr['aeq_id'])); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card m-b-0">
                <div class="card-header">
                    <h5><?php echo e(__('askexpert.answer.all_txt')); ?></h5>
                    <div class="c-f-btns">
                        <div class="c-f-b-f">
                            <!-- Filter -->
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.btn_filter','data' => []]); ?>
<?php $component->withName('form.btn_filter'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <!-- Reset -->
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.btn_reset','data' => []]); ?>
<?php $component->withName('form.btn_reset'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>
                        <div class="c-f-b-r">
                            <?php if($roleRights['delete']): ?>
                                <?php if(count($dataListModel) > 0): ?>
                                    &nbsp;
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
                            <?php endif; ?>
                        </div>
                    </div>
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
                    <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <form id="filterForm" name="filterForm" method="get" action="<?php echo e(route('admin.answer.index')); ?>">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <div class="sw-entry">
                                        <label>
                                            <?php echo e(__('admin.sw_entry.show_txt')); ?>

                                            <select name="ppage" aria-controls="example" class="form-control"
                                                onchange="form.submit();">
                                                <?php $__currentLoopData = $showEntryArr['value']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($option); ?>"
                                                        <?php echo e($option == $perPage ? 'selected' : ''); ?>>
                                                        <?php echo e($showEntryArr['text'][$key]); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php echo e(__('admin.sw_entry.entries_txt')); ?>

                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="row f-right">
                                        <div class="col-md-6">
                                            <div class="sort-by">
                                                <label>
                                                    <?php echo e(__('admin.sort_txt')); ?>

                                                    <select name="sby" aria-controls="example" class="form-control"
                                                        onchange="form.submit();">
                                                        <?php $__currentLoopData = $sortbyArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $sort): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($key); ?>"
                                                                <?php echo e($sortBy == $key ? 'selected' : ''); ?>>
                                                                <?php echo e($sort); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="order-by">
                                                <label>
                                                    <?php echo e(__('admin.order_by_txt')); ?>

                                                    <select name="oby" aria-controls="example" class="form-control"
                                                        onchange="form.submit();">
                                                        <?php $__currentLoopData = $orderbyArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $orderby): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($key); ?>"
                                                                <?php echo e(strtolower($orderBy) == $key ? 'selected' : ''); ?>>
                                                                <?php echo e($orderby); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <form id="listDataForm" name="listDataForm" method="post"
                        action="<?php echo e(route('admin.answer.delete')); ?>">
                        <?php echo e(csrf_field()); ?>

                        <div class="table-responsive dt-responsive">
                            <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <?php if($roleRights['delete']): ?>
                                            <?php if(count($dataListModel) > 0): ?>
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
                                        <th><?php echo e($sortbyArr['answer']); ?></th>
                                        <th class="cc-w-60 no-sort"><?php echo e(__('admin.status_txt')); ?></th>
                                        <th class="cc-w-150"><?php echo e($sortbyArr['created_at']); ?></th>
                                        <th class="cc-w-150"><?php echo e(__('admin.added_user_txt')); ?></th>
                                        <th class="cc-w-150"><?php echo e($sortbyArr['updated_at']); ?></th>
                                        <th class="cc-w-95"><?php echo e(__('admin.mdfy_by_txt')); ?></th>
                                        <th class="cc-w-150 no-sort"><?php echo e(__('admin.mdfy_user_txt')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php if($roleRights['delete']): ?>
                                            <?php if(count($dataListModel) > 0): ?>
                                                <td></td>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <td>
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'far','name' => 'far','value' => ''.e($fltrDataArr['answer'] ?? '').'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'far','name' => 'far','value' => ''.e($fltrDataArr['answer'] ?? '').'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        </td>
                                        <td>
                                            <select id="fst" class="form-control" name="fst">
                                                <option value=""
                                                    <?php echo e(!isset($fltrDataArr['status']) || $fltrDataArr['status'] == '' ? 'selected' : ''); ?>>
                                                    <?php echo e($cFilterArr['all_txt']); ?></option>
                                                <?php $__currentLoopData = $moduleAtrArr['status']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($id); ?>"
                                                        <?php echo e(isset($fltrDataArr['status']) && $id == $fltrDataArr['status'] ? 'selected' : ''); ?>>
                                                        <?php echo e($status); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </td>
                                        <td>
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'fca','name' => 'fca','value' => ''.e($fltrDataArr['created_at'] ?? '').'','class' => 'period']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'fca','name' => 'fca','value' => ''.e($fltrDataArr['created_at'] ?? '').'','class' => 'period']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'fcu','name' => 'fcu','value' => ''.e($fltrDataArr['created_user'] ?? '').'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'fcu','name' => 'fcu','value' => ''.e($fltrDataArr['created_user'] ?? '').'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'fua','name' => 'fua','value' => ''.e($fltrDataArr['updated_at'] ?? '').'','class' => 'period']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'fua','name' => 'fua','value' => ''.e($fltrDataArr['updated_at'] ?? '').'','class' => 'period']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        </td>
                                        <td>
                                            <select name="fub" id="fub" aria-controls="example" class="form-control">
                                                <option value=""><?php echo e($cFilterArr['all_txt']); ?></option>
                                                <?php $__currentLoopData = $moduleAtrArr['cu_by_val']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $fmbyVal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($fmbyVal); ?>"
                                                        <?php if($fmbyVal == old('fub')): ?> <?php echo e('selected'); ?> <?php elseif($fmbyVal == $fltrDataArr['updated_by']): ?> <?php echo e('selected'); ?> <?php endif; ?>>
                                                        <?php echo e($moduleAtrArr['cu_by_txt'][$fmbyVal]); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php if(count($dataListModel) > 0): ?>
                                        <?php $__currentLoopData = $dataListModel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr role="row" class="">
                                                <?php if($roleRights['delete']): ?>
                                                    <td class="sorting_<?php echo e($record->aeqa_id); ?>">
                                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.checkbox','data' => ['style' => 'default','name' => 'checkbox[]','value' => ''.e($record->aeqa_id).'','fldclass' => 'del-chkbx']]); ?>
<?php $component->withName('form.field.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['style' => 'default','name' => 'checkbox[]','value' => ''.e($record->aeqa_id).'','fldclass' => 'del-chkbx']); ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_tooltip','data' => ['url' => ''.e(route('admin.answer.edit', $record->aeqa_id)).'','title' => ''.e($listDataAtrArr['edit_txt']).'']]); ?>
<?php $component->withName('link_tooltip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.answer.edit', $record->aeqa_id)).'','title' => ''.e($listDataAtrArr['edit_txt']).'']); ?>
                                                            <?php echo \App\Lib\Core\Useful::getShortContent(strip_tags($record->answer), $moduleAtrArr['descp_char_lngth']); ?>

                                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                    <?php else: ?>
                                                        <?php echo \App\Lib\Core\Useful::getShortContent(strip_tags($record->answer), $moduleAtrArr['descp_char_lngth']); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <label
                                                        class="label btn-<?php echo e($listDataAtrArr['alert_css'][$record->status]); ?> no-drop"><?php echo e($moduleAtrArr['status'][$record->status]); ?></label>
                                                </td>
                                                <td><?php echo e(date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->created_at))); ?>

                                                </td>
                                                <td>
                                                    <?php if($record->addedbyuser->f_name): ?>
                                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_tooltip','data' => ['url' => ''.e(route('admin.subscribeduser.edit', $record->addedbyuser->u_id)).'','title' => ''.e($moduleAtrArr['view_txt']).'','target' => ''.e($moduleAtrArr['target']).'']]); ?>
<?php $component->withName('link_tooltip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.subscribeduser.edit', $record->addedbyuser->u_id)).'','title' => ''.e($moduleAtrArr['view_txt']).'','target' => ''.e($moduleAtrArr['target']).'']); ?>
                                                            <?php echo e($record->addedbyuser->f_name . ' ' . $record->addedbyuser->l_name); ?>

                                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                    <?php else: ?>
                                                        <?php echo e($listDataAtrArr['unknown_txt']); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($record->updated_at != ''): ?>
                                                        <?php echo e(date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->updated_at))); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($record->updated_by != ''): ?>
                                                        <?php echo e($moduleAtrArr['cu_by_txt'][$record->updated_by] ?? $listDataAtrArr['unknown_txt']); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($record->updated_by != ''): ?>
                                                        <?php switch($record->updated_by):
                                                            case ($moduleAtrArr['cu_by_val'][1]): ?>
                                                                <?php echo e($record->updatedby->display_name ?? $listDataAtrArr['unknown_txt']); ?>

                                                            <?php break; ?>

                                                            <?php case ($moduleAtrArr['cu_by_val'][2]): ?>
                                                                <?php echo e($record->updatedbyuser->f_name . ' ' . $record->updatedbyuser->l_name ?? $listDataAtrArr['unknown_txt']); ?>

                                                            <?php break; ?>
                                                        <?php endswitch; ?>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8"><?php echo e(__('message.data_not_available')); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <?php echo e($dataListModel->appends($data)->links('vendor.pagination.app-admin')); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        /*Filter*/
        function filter() {
            var searchPagiData = "";
            var ftrFarVlu = document.getElementById("far").value;
            if (ftrFarVlu != "") {
                searchPagiData = searchPagiData + "&far=" + ftrFarVlu;
            }
            var ftrFstVlu = document.getElementById("fst").value;
            if (ftrFstVlu != "") {
                searchPagiData = searchPagiData + "&fst=" + ftrFstVlu;
            }
            var ftrFcaVlu = document.getElementById("fca").value;
            if (ftrFcaVlu != "") {
                searchPagiData = searchPagiData + "&fca=" + ftrFcaVlu;
            }
            var ftrFcuVlu = document.getElementById("fcu").value;
            if (ftrFcuVlu != "") {
                searchPagiData = searchPagiData + "&fcu=" + ftrFcuVlu;
            }
            var ftrFuaVlu = document.getElementById("fua").value;
            if (ftrFuaVlu != "") {
                searchPagiData = searchPagiData + "&fua=" + ftrFuaVlu;
            }
            var ftrFubVlu = document.getElementById("fub").value;
            if (ftrFubVlu != "") {
                searchPagiData = searchPagiData + "&fub=" + ftrFubVlu;
            }
            /*alert(searchPagiData);*/
            window.location.href = "<?php echo e(route('admin.answer.list', $fltrDataArr['aeq_id'])); ?>" + "?page=0" +
                searchPagiData + "&ppage=" + "<?php echo e($perPage); ?>";
            return false;
        }
        /*Reset Filter*/
        function resetfilter() {
            window.location.href = "<?php echo e(route('admin.answer.list', $fltrDataArr['aeq_id'])); ?>";
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/backend/pages/answer/index.blade.php ENDPATH**/ ?>