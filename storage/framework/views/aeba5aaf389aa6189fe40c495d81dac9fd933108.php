<?php $__env->startSection('datetimePicker'); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<?php echo e(Breadcrumbs::render('currencies.list')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card m-b-0">
            <div class="card-header">
                <h5><?php echo e(__('admin.currency.list.label_txt')); ?></h5>
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
                        <?php if( count( $dataListModel ) > 0 ): ?>
                        <?php if($roleRights['delete']): ?>
                        <form id="listDataForm" name="listDataForm" method="post" action="<?php echo e(route('admin.currencies.delete')); ?>">
                            <?php echo e(csrf_field()); ?>

                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.button_def','data' => ['type' => 'submit','name' => 'submit','text' => ''.e(__('admin.del_last_saved_pfx_txt').$lastSavedDate.__('admin.del_last_saved_sfx_txt')).'','class' => 'btn btn-sm waves-effect waves-light btn-danger btn-square','onclick' => 'return confirm(\''.e(__('message.confirm.del_last_saved')).'\')?confirm(\''.e(__('message.confirm.click_ok_txt')).'\'):false']]); ?>
<?php $component->withName('form.field.button_def'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'submit','name' => 'submit','text' => ''.e(__('admin.del_last_saved_pfx_txt').$lastSavedDate.__('admin.del_last_saved_sfx_txt')).'','class' => 'btn btn-sm waves-effect waves-light btn-danger btn-square','onclick' => 'return confirm(\''.e(__('message.confirm.del_last_saved')).'\')?confirm(\''.e(__('message.confirm.click_ok_txt')).'\'):false']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </form>
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
                    <form id="filterForm" name="filterForm" method="get" action="<?php echo e(route('admin.currencies.list')); ?>">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <div class="sw-entry">
                                    <label>
                                        <?php echo e(__('admin.sw_entry.show_txt')); ?>

                                        <select name="ppage" aria-controls="example" class="form-control" onchange="form.submit();">
                                            <?php $__currentLoopData = $showEntryArr['value']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($option); ?>" <?php echo e($option == $perPage ? 'selected' : ''); ?>><?php echo e($showEntryArr['text'][$key]); ?></option>
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

                                                <select name="sby" id="sby" aria-controls="example" class="form-control" onchange="filter();">
                                                    <?php $__currentLoopData = $sortbyArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$sort): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($key); ?>" <?php echo e($sortBy==$key?'selected':''); ?>><?php echo e($sort); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="order-by">
                                            <label>
                                                <?php echo e(__('admin.order_by_txt')); ?>

                                                <select name="oby" id="oby" aria-controls="example" class="form-control" onchange="filter();">
                                                    <?php $__currentLoopData = $orderbyArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $orderby): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($key); ?>" <?php echo e(strtolower($orderBy) == $key ? 'selected' : ''); ?>><?php echo e($orderby); ?></option>
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
                <div class="table-responsive dt-responsive">
                    <table class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th class="cc-w-125"><?php echo e(__('admin.entry_date_txt')); ?></th>
                                <th><?php echo e($sortbyArr['cur_name']); ?></th>
                                <th class="cc-w-125"><?php echo e($sortbyArr['entry_value']); ?></th>
                                <th class="cc-w-125"><?php echo e(__('admin.publish_txt')); ?></th>
                                <th><?php echo e(__('admin.added_user_txt')); ?></th>
                                <th class="cc-w-150"><?php echo e(__('admin.added_date_txt')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'fed','name' => 'fed','value' => ''.e($fltrDataArr['entry_date'] ?? '').'','class' => 'def-date']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'fed','name' => 'fed','value' => ''.e($fltrDataArr['entry_date'] ?? '').'','class' => 'def-date']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </td>
                                <td>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.text','data' => ['id' => 'fcn','name' => 'fcn','value' => ''.e($fltrDataArr['cur_name'] ?? '').'']]); ?>
<?php $component->withName('form.field.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'fcn','name' => 'fcn','value' => ''.e($fltrDataArr['cur_name'] ?? '').'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php if( count($dataListModel) > 0 ): ?>
                            <?php $__currentLoopData = $dataListModel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr role="row" class="">
                                <td><?php echo e($record->entry_date); ?></td>
                                <td><?php echo e($record->cur_name); ?></td>
                                <td><?php echo e($record->entry_value); ?></td>
                                <td><?php echo e($moduleAtrArr['published'][$record->publish]); ?></td>
                                <td><?php echo e($record->createdby->display_name ?? $listDataAtrArr['unknown_txt']); ?></td>
                                <td><?php echo e(date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->created_at))); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="6"><?php echo e(__('message.data_not_available')); ?></td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
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
        var ftrFedVlu = document.getElementById("fed").value;
        if (ftrFedVlu != "") {
            searchPagiData = searchPagiData + "&fed=" + ftrFedVlu;
        }
        var ftrFcnVlu = document.getElementById("fcn").value;
        if (ftrFcnVlu != "") {
            searchPagiData = searchPagiData + "&fcn=" + ftrFcnVlu;
        }
        var ftrSbyVlu = document.getElementById("sby").value;
        if (ftrSbyVlu != "") {
            searchPagiData = searchPagiData + "&sby=" + ftrSbyVlu;
        }
        var ftrObyVlu = document.getElementById("oby").value;
        if (ftrObyVlu != "") {
            searchPagiData = searchPagiData + "&oby=" + ftrObyVlu;
        }
        /*alert(searchPagiData);*/
        window.location.href = "<?php echo e(route('admin.currencies.list')); ?>" + "?page=0" + searchPagiData + "&ppage=" + "<?php echo e($perPage); ?>";
        return false;
    }
    /*Reset Filter*/
    function resetfilter() {
        window.location.href = "<?php echo e(route('admin.currencies.list')); ?>";
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/backend/pages/currency/list.blade.php ENDPATH**/ ?>